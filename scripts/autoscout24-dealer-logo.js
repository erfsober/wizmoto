#!/usr/bin/env node

/**
 * Headless helper to extract a dealer (provider) logo image URL from
 * a single Autoscout24 ad detail page.
 *
 * Usage:
 *   node scripts/autoscout24-dealer-logo.js "<adUrl>"
 *
 * Prints a JSON object to stdout:
 *   { "logoUrl": "https://..." }  // or { "logoUrl": null } if not found
 *
 * NOTE: Requires Playwright:
 *   npm install playwright
 */

import { chromium } from 'playwright';

async function main() {
  const adUrl = process.argv[2];
  if (!adUrl) {
    process.stdout.write(JSON.stringify({ logoUrl: null }));
    return;
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

    // Give the seller box a moment to render.
    await page.waitForTimeout(3000);

    // Try several reasonable selectors for a dealer/seller logo image.
    const logoUrl = await page.evaluate(() => {
      const selectors = [
        // New stage dealer logo on detail page / dealer page.
        'img[data-testid="stage-dealer-logo"]',
        'img[src*="dealer-info"]',
        // Explicit testids if present.
        '[data-testid="seller-logo"] img',
        '[data-testid="dealer-logo"] img',
        // Common patterns: logo inside seller card/header.
        'section [class*="Seller"] img',
        'section [class*="seller"] img',
        'aside [class*="Seller"] img',
        'aside [class*="seller"] img',
        // Any image with alt mentioning logo.
        'img[alt*="logo" i]',
      ];

      for (const sel of selectors) {
        const img = document.querySelector(sel);
        if (img) {
          const src = img.getAttribute('src') || img.getAttribute('data-src');
          if (src && src.trim() !== '') {
            return src;
          }
        }
      }

      return null;
    });

    await browser.close();

    // Normalize relative URLs if needed.
    let full = logoUrl;
    if (logoUrl && !logoUrl.startsWith('http')) {
      if (logoUrl.startsWith('//')) {
        full = 'https:' + logoUrl;
      } else if (logoUrl.startsWith('/')) {
        full = 'https://www.autoscout24.it' + logoUrl;
      } else {
        full = 'https://www.autoscout24.it/' + logoUrl;
      }
    }

    process.stdout.write(JSON.stringify({ logoUrl: full || null }));
  } catch {
    await browser.close();
    process.stdout.write(JSON.stringify({ logoUrl: null }));
  }
}

main().catch(() => {
  // On error, just return null logo (PHP side treats as "no logo").
  process.stdout.write(JSON.stringify({ logoUrl: null }));
});


