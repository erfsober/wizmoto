#!/usr/bin/env node

/**
 * Headless helper to fetch the fully rendered HTML of an Autoscout24 ad detail page.
 * This is needed because Autoscout24 requires JavaScript to render the page content.
 *
 * Usage:
 *   node scripts/autoscout24-ad-html.js "<adUrl>"
 *
 * Prints the full HTML content to stdout.
 *
 * NOTE: Requires Playwright:
 *   npm install playwright
 */

import { chromium } from 'playwright';

async function main() {
  const adUrl = process.argv[2];
  if (!adUrl) {
    process.stderr.write('Error: No URL provided\n');
    process.exit(1);
  }

  const browser = await chromium.launch({
    headless: true,
    args: ['--no-sandbox', '--disable-dev-shm-usage'],
  });

  const page = await browser.newPage({
    userAgent:
      'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
  });

  try {
    await page.goto(adUrl, {
      waitUntil: 'domcontentloaded',
      timeout: 60000,
    });

    // Wait for the page to load - check for key elements that indicate the ad page has loaded
    try {
      // Wait for common ad page elements
      await Promise.race([
        page.waitForSelector('h1', { timeout: 15000 }),
        page.waitForSelector('[data-testid*="price"]', { timeout: 15000 }),
        page.waitForSelector('.price', { timeout: 15000 }),
        page.waitForSelector('meta[property="og:title"]', { timeout: 15000 }),
      ]).catch(() => {
        // If none of these load, continue anyway - page might be structured differently
      });
    } catch {
      // Ignore timeout, continue anyway
    }

    // Wait a bit more for JavaScript to render all content
    await page.waitForTimeout(2000);

    // Get the full HTML content
    const html = await page.content();

    await browser.close();

    // Output the HTML
    process.stdout.write(html);
  } catch (err) {
    await browser.close();
    process.stderr.write(`Error: ${err && err.message ? err.message : String(err)}\n`);
    process.exit(1);
  }
}

main().catch((err) => {
  process.stderr.write(`Fatal error: ${err && err.stack ? err.stack : String(err)}\n`);
  process.exit(1);
});

