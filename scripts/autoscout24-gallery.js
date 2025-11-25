#!/usr/bin/env node

/**
 * Headless helper to extract ALL gallery image URLs from a single
 * Autoscout24 ad detail page.
 *
 * Usage:
 *   node scripts/autoscout24-gallery.js "<adUrl>"
 *
 * Prints a JSON array to stdout:
 *   ["https://prod.pictures.autoscout24.net/listing-images/.../1920x1080.webp", ...]
 *
 * NOTE: Requires Playwright:
 *   npm install playwright
 */

import { chromium } from 'playwright';

async function main() {
  const adUrl = process.argv[2];
  if (!adUrl) {
    process.stdout.write(JSON.stringify([]));
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

    // Give the gallery a bit of time to load its images.
    await page.waitForTimeout(4000);

    // Try to collect all gallery images that point to listing-images.
    const urls = await page.$$eval('img', (nodes) => {
      const base = 'https://www.autoscout24.it';
      const out = [];

      for (const n of nodes) {
        let src = n.getAttribute('data-src') || n.getAttribute('src');
        if (!src) continue;
        src = src.trim();
        if (!src) continue;

        // Only keep images from the listing-images CDN, which are actual vehicle photos.
        if (!src.includes('listing-images')) continue;

        // Normalize to absolute URL.
        let full = src;
        if (src.startsWith('//')) {
          full = 'https:' + src;
        } else if (src.startsWith('/')) {
          full = base + src;
        } else if (!src.startsWith('http')) {
          full = base + '/' + src;
        }

        out.push(full);
      }

      // Remove duplicates.
      return Array.from(new Set(out));
    });

    await browser.close();
    process.stdout.write(JSON.stringify(urls));
  } catch {
    await browser.close();
    process.stdout.write(JSON.stringify([]));
  }
}

main().catch(() => {
  // On error, just return empty array; PHP side treats as "no extra images".
  process.stdout.write(JSON.stringify([]));
});


