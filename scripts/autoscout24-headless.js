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

  // Wait for page to load
  try {
    await page.waitForSelector('a[href^="/annunci/"]', { timeout: 15000 });
  } catch {
    // Ignore timeout
  }
  await page.waitForTimeout(2000);

  // Extract base URL and search_id from current URL for pagination
  const initialUrl = page.url();
  const urlObj = new URL(initialUrl);
  const searchId = urlObj.searchParams.get('search_id');
  const baseSearchParams = new URLSearchParams(urlObj.search);
  
  process.stderr.write(`Initial URL: ${initialUrl}\n`);
  process.stderr.write(`Search ID: ${searchId || 'not found'}\n`);

  // Loop through pages until we have enough URLs or run out of pages
  while (allUrls.size < limit && hasMorePages && currentPage <= maxPages) {
    // Extract URLs from current page
    const pageUrls = await extractUrlsFromPage();

    // Add new URLs to our collection
    const urlsBeforeAdd = allUrls.size;
    for (const url of pageUrls) {
      if (allUrls.size >= limit) {
        break;
      }
      allUrls.add(url);
    }
    const urlsAfterAdd = allUrls.size;

    // Debug: log page info to stderr (so it doesn't interfere with JSON output)
    process.stderr.write(`Page ${currentPage}: Found ${pageUrls.length} URLs, Total: ${allUrls.size}/${limit}\n`);

    // Check if we have enough URLs
    if (allUrls.size >= limit) {
      break;
    }

    // Check if we got any new URLs from this page
    if (urlsAfterAdd === urlsBeforeAdd && pageUrls.length > 0) {
      // We're getting duplicate URLs, might be stuck on same page
      process.stderr.write(`Warning: No new URLs added from page ${currentPage}, might be duplicate content\n`);
    }

    // Navigate to next page using URL-based pagination
    try {
      process.stderr.write(`[Page ${currentPage}] Need more URLs (${allUrls.size}/${limit}), navigating to page ${currentPage + 1}...\n`);
      
      // Get current page's first URL for comparison
      const urlsBeforeNav = await extractUrlsFromPage();
      const firstUrlBeforeNav = urlsBeforeNav.length > 0 ? urlsBeforeNav[0] : null;
      
      // Build next page URL - preserve all query parameters from current URL
      const nextPageNum = currentPage + 1;
      const currentUrl = page.url();
      const nextPageUrlObj = new URL(currentUrl);
      
      // Update page parameter
      nextPageUrlObj.searchParams.set('page', nextPageNum.toString());
      
      // Ensure search_id is included (get from current URL if available)
      const currentSearchId = nextPageUrlObj.searchParams.get('search_id');
      if (!currentSearchId && searchId) {
        nextPageUrlObj.searchParams.set('search_id', searchId);
      }
      
      // Add source parameter if not present (required for pagination to work)
      if (!nextPageUrlObj.searchParams.has('source')) {
        nextPageUrlObj.searchParams.set('source', 'listpage_pagination');
      }
      
      const nextPageUrl = nextPageUrlObj.toString();
      process.stderr.write(`[Page ${currentPage}] Navigating to: ${nextPageUrl}\n`);
      
      // Navigate to next page
      await page.goto(nextPageUrl, {
        waitUntil: 'domcontentloaded',
        timeout: 60000,
      });
      
      // Wait for page to load
      await page.waitForTimeout(3000);
      
      try {
        await page.waitForSelector('a[href^="/annunci/"]', { timeout: 10000 });
      } catch {
        // Continue anyway
      }
      
      // Verify we got new content by checking if first URL changed
      const urlsAfterNav = await extractUrlsFromPage();
      const firstUrlAfterNav = urlsAfterNav.length > 0 ? urlsAfterNav[0] : null;
      
      if (urlsAfterNav.length === 0) {
        process.stderr.write(`[Page ${currentPage}] ✗ No listings found on page ${nextPageNum}. Stopping.\n`);
        hasMorePages = false;
        break;
      }
      
      if (firstUrlAfterNav && firstUrlAfterNav !== firstUrlBeforeNav) {
        // We got different URLs, navigation successful
        currentPage = nextPageNum;
        process.stderr.write(`[Page ${currentPage}] ✓ Successfully navigated! Found ${urlsAfterNav.length} listings.\n`);
        continue;
      } else if (urlsAfterNav.length > 0) {
        // Got URLs but might be same as before (shouldn't happen, but continue)
        currentPage = nextPageNum;
        process.stderr.write(`[Page ${currentPage}] ⚠ Navigated but URLs appear similar. Continuing anyway...\n`);
        continue;
      } else {
        process.stderr.write(`[Page ${currentPage}] ✗ Navigation failed - no new listings found. Stopping.\n`);
        hasMorePages = false;
        break;
      }
      
    } catch (err) {
      process.stderr.write(`[Page ${currentPage}] ✗ Error during pagination: ${err.message}\n`);
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


