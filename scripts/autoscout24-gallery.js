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

    // Collect gallery images from the main image slider, preferring JPEG variants
    // from the <picture><source type="image/jpeg"> tags, and falling back to
    // the <img src> if needed.
    const urls = await page.$$eval('.image-gallery-slides picture', (pictures) => {
      const out = [];

      const normalize = (url) => {
        if (!url) return null;
        let src = url.trim();
        if (!src) return null;

        // We only care about the listing-images CDN (real vehicle photos).
        if (!src.includes('listing-images')) return null;

        // srcset may contain "url 1x" → take the first token as the URL.
        const firstPart = src.split(/\s+/)[0];
        return firstPart;
      };

      for (const picture of pictures) {
        let chosen = null;

        // 1) Prefer JPEG sources (more compatible than webp for some stacks).
        const jpegSources = Array.from(
          picture.querySelectorAll('source[type="image/jpeg"][srcset]')
        );
        if (jpegSources.length > 0) {
          // Take the last one (usually the largest resolution).
          const last = jpegSources[jpegSources.length - 1];
          chosen = normalize(last.getAttribute('srcset') || '');
        }

        // 2) Fallback to the <img src> inside the picture.
        if (!chosen) {
          const img = picture.querySelector('img');
          if (img) {
            chosen = normalize(img.getAttribute('src') || img.getAttribute('data-src') || '');
          }
        }

        if (chosen) {
          out.push(chosen);
        }
      }

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


