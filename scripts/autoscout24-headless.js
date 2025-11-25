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

  await page.goto(searchUrl, { waitUntil: 'networkidle' });

  // Wait for at least one listing link to appear (best-effort).
  try {
    await page.waitForSelector('a[href^="/annunci/"]', { timeout: 15000 });
  } catch {
    // Ignore timeout; we'll just see what links we have.
  }

  // Small extra delay to let more cards render.
  await page.waitForTimeout(2000);

  const hrefs = await page.$$eval('a[href^="/annunci/"]', (nodes) => {
    const all = nodes
      .map((n) => n.getAttribute('href'))
      .filter((href) => typeof href === 'string' && href.trim() !== '');

    return Array.from(new Set(all));
  });

  await browser.close();

  const base = 'https://www.autoscout24.it';

  const urls = hrefs
    .map((href) => (href.startsWith('http') ? href : base + href))
    .slice(0, limit);

  process.stdout.write(JSON.stringify(urls));
}

main().catch((err) => {
  // Log the error so Laravel's shell_exec (with 2>&1) can capture it into laravel.log.
  // This lets us see Playwright/Node problems instead of just \"empty output\".
  console.error(err && err.stack ? err.stack : String(err));
  process.exit(1);
});


