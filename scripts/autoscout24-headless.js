#!/usr/bin/env node

/**
 * Minimal headless scraper for Autoscout24 listings.
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

  // Collect JSON responses so we can fall back to extracting listing URLs
  // directly from API payloads if the DOM structure changes.
  const jsonBodies = [];

  page.on('response', async (response) => {
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
  });

  // Avoid "networkidle" on heavy ad/analytics pages (it may never settle).
  // Use a longer timeout and rely on our own waits/selectors instead.
  await page.goto(searchUrl, {
    waitUntil: 'domcontentloaded',
    timeout: 60000,
  });

  // Wait for at least one listing link to appear (best-effort).
  try {
    await page.waitForSelector('a[href^="/annunci/"]', { timeout: 15000 });
  } catch {
    // Ignore timeout; we'll just see what links we have.
  }

  // Small extra delay to let more cards and XHRs complete.
  await page.waitForTimeout(2000);

  const base = 'https://www.autoscout24.it';

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

  let urls = detailHrefs
    // Normalise to absolute URLs on autoscout24.it
    .map((href) => (href.startsWith('http') ? href : base + href))
    .filter((url) => url.startsWith(base));

  // If DOM-based scraping didn't find anything useful, fall back to JSON payloads.
  if (urls.length === 0 && jsonBodies.length > 0) {
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
        if (fromJson.size >= limit) break;
      }

      if (fromJson.size >= limit) break;

      // Relative URLs.
      while ((match = relRegex.exec(body)) !== null) {
        const path = match[1];
        fromJson.add(base + path);
        if (fromJson.size >= limit) break;
      }

      if (fromJson.size >= limit) break;
    }

    urls = Array.from(fromJson);
  }

  await browser.close();

  process.stdout.write(JSON.stringify(urls.slice(0, limit)));
}

main().catch((err) => {
  // Log the error so Laravel's shell_exec (with 2>&1) can capture it into laravel.log.
  // This lets us see Playwright/Node problems instead of just \"empty output\".
  console.error(err && err.stack ? err.stack : String(err));
  process.exit(1);
});


