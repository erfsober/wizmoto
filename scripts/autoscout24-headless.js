#!/usr/bin/env node

/**
 * Minimal headless scraper for Autoscout24 listings with pagination support.
 *
 * Usage:
 *   node scripts/autoscout24-headless.js "<searchUrl>" <limit>
 *
 * Prints a JSON array of absolute ad URLs to stdout.
 *
 * NOTE: Requires Playwright:
 *   npm install playwright
 */

import { chromium } from 'playwright';

async function main() {
  const searchUrl = process.argv[2] || 'https://www.autoscout24.it/lst-moto';
  const limit = parseInt(process.argv[3] || '10', 10) || 10;

  // In some Linux/container environments (especially when running as root),
  // Chromium's sandbox causes the browser to immediately crash with
  // "Target page, context or browser has been closed". Disabling the sandbox
  // and dev-shm usage makes it work reliably in those environments.
  const browser = await chromium.launch({
    headless: true,
    args: ['--no-sandbox', '--disable-dev-shm-usage'],
  });
  const page = await browser.newPage({
    userAgent:
      'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
  });

  const base = 'https://www.autoscout24.it';
  const allUrls = new Set();
  let currentPage = 1;
  const maxPages = 50; // Safety limit to prevent infinite loops
  let hasMorePages = true;

  // Function to extract URLs from current page
  const extractUrlsFromPage = async () => {
    const jsonBodies = [];

    // Collect JSON responses so we can fall back to extracting listing URLs
    // directly from API payloads if the DOM structure changes.
    const responseListener = async (response) => {
      try {
        const headers = response.headers();
        const rawContentType = headers['content-type'] || headers['Content-Type'] || '';
        const contentType = rawContentType.toLowerCase();

        // Keep any response that looks JSON-ish, not just strict application/json.
        if (!contentType.includes('json')) {
          return;
        }

        const text = await response.text();
        if (!text) {
          return;
        }

        jsonBodies.push(text);
      } catch {
        // Ignore network/parse errors here; this is best-effort.
      }
    };

    page.on('response', responseListener);

    // Wait for at least one listing link to appear (best-effort).
    try {
      await page.waitForSelector('a[href^="/annunci/"]', { timeout: 15000 });
    } catch {
      // Ignore timeout; we'll just see what links we have.
    }

    // Small extra delay to let more cards and XHRs complete.
    await page.waitForTimeout(2000);

    // First try DOM-based extraction for links that look like listings.
    const hrefs = await page.$$eval('a[href]', (nodes) => {
      const all = nodes
        .map((n) => n.getAttribute('href'))
        .filter((href) => typeof href === 'string' && href.trim() !== '');

      // Return unique hrefs only; filtering is done in Node context.
      return Array.from(new Set(all));
    });

    // Prefer explicit ad-detail links. On Autoscout24 these commonly live under
    // country-specific ad paths such as "/annunci/..." or "/offerta/...".
    const detailHrefs = hrefs.filter(
      (href) => href.includes('/annunci/') || href.includes('/offerta/'),
    );

    let pageUrls = detailHrefs
      // Normalise to absolute URLs on autoscout24.it
      .map((href) => (href.startsWith('http') ? href : base + href))
      .filter((url) => url.startsWith(base) && url.includes('/annunci/'));

    // If DOM-based scraping didn't find anything useful, fall back to JSON payloads.
    if (pageUrls.length === 0 && jsonBodies.length > 0) {
      const fromJson = new Set();

      // 1) Absolute ad URLs, e.g. "https://www.autoscout24.it/annunci/..."
      const absRegex = /https:\/\/www\.autoscout24\.it\/annunci\/[^\s"']+/g;
      // 2) Relative ad URLs inside JSON strings, e.g. "\/annunci\/honda-..."
      const relRegex = /"(\/annunci\/[^"']+)"/g;

      for (const body of jsonBodies) {
        let match;

        // Absolute URLs.
        while ((match = absRegex.exec(body)) !== null) {
          fromJson.add(match[0]);
        }

        // Relative URLs.
        while ((match = relRegex.exec(body)) !== null) {
          const path = match[1];
          fromJson.add(base + path);
        }
      }

      pageUrls = Array.from(fromJson);
    }

    page.off('response', responseListener);

    return pageUrls;
  };

  // Navigate to first page
  await page.goto(searchUrl, {
    waitUntil: 'domcontentloaded',
    timeout: 60000,
  });

  // Loop through pages until we have enough URLs or run out of pages
  while (allUrls.size < limit && hasMorePages && currentPage <= maxPages) {
    // Extract URLs from current page
    const pageUrls = await extractUrlsFromPage();

    // Add new URLs to our collection
    for (const url of pageUrls) {
      if (allUrls.size >= limit) {
        break;
      }
      allUrls.add(url);
    }

    // Check if we have enough URLs
    if (allUrls.size >= limit) {
      break;
    }

    // Try to navigate to next page
    let navigated = false;
    
    try {
      // Strategy 1: Try URL-based pagination (most reliable)
      const currentUrl = page.url();
      const urlObj = new URL(currentUrl);
      const pageParam = urlObj.searchParams.get('page') || urlObj.searchParams.get('p');
      const currentPageNum = pageParam ? parseInt(pageParam) : (currentPage || 1);
      const nextPageNum = currentPageNum + 1;

      // Try to navigate to next page URL
      urlObj.searchParams.set('page', nextPageNum.toString());
      const nextPageUrl = urlObj.toString();

      if (nextPageUrl !== currentUrl) {
        try {
          await page.goto(nextPageUrl, {
            waitUntil: 'domcontentloaded',
            timeout: 60000,
          });

          await page.waitForTimeout(2000);

          // Check if we actually got new listings
          const testUrls = await extractUrlsFromPage();
          
          if (testUrls.length > 0) {
            // We got listings, continue with this page
            navigated = true;
            currentPage = nextPageNum;
            continue;
          }
          // No listings found, but try alternative pagination methods
        } catch (err) {
          // Navigation failed, try button clicking
        }
      }

      // Strategy 2: Try clicking next button if URL pagination didn't work
      if (!navigated) {
        const possibleSelectors = [
          'button[aria-label*="next" i]',
          'a[aria-label*="next" i]',
          'button[aria-label*="Avanti" i]',
          'a[aria-label*="Avanti" i]',
          '[data-testid*="next"]',
          '[data-testid*="pagination-next"]',
          '.pagination-next',
          '[class*="pagination-next"]',
        ];

        for (const selector of possibleSelectors) {
          try {
            const button = await page.$(selector);
            if (button) {
              const isDisabled = await button.evaluate((el) => {
                return el.hasAttribute('disabled') || 
                       el.classList.contains('disabled') || 
                       el.getAttribute('aria-disabled') === 'true' ||
                       el.classList.contains('pagination-item--disabled') ||
                       el.getAttribute('href') === '#' ||
                       el.getAttribute('href') === '';
              });

              if (!isDisabled) {
                await button.click();
                await page.waitForTimeout(3000);
                navigated = true;
                currentPage++;
                break;
              }
            }
          } catch {
            // Continue to next selector
          }
        }
      }

      // Strategy 3: Look for next page link in pagination area
      if (!navigated) {
        try {
          const nextLink = await page.evaluate(() => {
            const links = Array.from(document.querySelectorAll('a[href]'));
            for (const link of links) {
              const text = (link.textContent || '').trim().toLowerCase();
              const ariaLabel = (link.getAttribute('aria-label') || '').trim().toLowerCase();
              const href = link.getAttribute('href') || '';
              
              if ((text.match(/^(›|»|next|avanti|successivo)$/i) || 
                   ariaLabel.match(/next|avanti|successivo/i)) &&
                  href && href !== '#' && !href.includes('#')) {
                return href;
              }
            }
            return null;
          });

          if (nextLink) {
            const fullUrl = nextLink.startsWith('http') ? nextLink : new URL(nextLink, base).toString();
            await page.goto(fullUrl, {
              waitUntil: 'domcontentloaded',
              timeout: 60000,
            });
            await page.waitForTimeout(2000);
            navigated = true;
            currentPage++;
            continue;
          }
        } catch {
          // Ignore errors
        }
      }

      // If we couldn't navigate to next page, stop
      if (!navigated) {
        hasMorePages = false;
        break;
      }
    } catch (err) {
      // Error occurred, assume no more pages
      hasMorePages = false;
      break;
    }
  }

  await browser.close();

  // Return unique URLs up to the limit
  const finalUrls = Array.from(allUrls).slice(0, limit);
  process.stdout.write(JSON.stringify(finalUrls));
}

main().catch((err) => {
  // Log the error so Laravel's shell_exec (with 2>&1) can capture it into laravel.log.
  // This lets us see Playwright/Node problems instead of just \"empty output\".
  console.error(err && err.stack ? err.stack : String(err));
  process.exit(1);
});


