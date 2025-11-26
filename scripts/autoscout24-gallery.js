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

    const urls = await page.evaluate(() => {
      const out = [];

      const normalize = (url) => {
        if (!url) return null;
        let src = url.trim();
        if (!src) return null;

        // Strip query params so the same physical image with different
        // ?width= / ?height= variants is treated as one image.
        if (src.includes('?')) {
          src = src.split('?')[0];
        }

        // We only care about the listing-images CDN (real vehicle photos).
        if (!src.includes('listing-images')) return null;

        // srcset may contain "url 1x" → take the first token as the URL.
        const firstPart = src.split(/\s+/)[0];
        return firstPart;
      };

      // 1) Prefer <picture><source type="image/jpeg"> where available.
      const pictures = Array.from(document.querySelectorAll('picture'));
      for (const picture of pictures) {
        let chosen = null;

        const jpegSources = Array.from(
          picture.querySelectorAll('source[type="image/jpeg"][srcset]')
        );
        if (jpegSources.length > 0) {
          const last = jpegSources[jpegSources.length - 1];
          chosen = normalize(last.getAttribute('srcset') || '');
        }

        // Fallback: try any <img> inside the picture.
        if (!chosen) {
          const img = picture.querySelector('img');
          if (img) {
            chosen = normalize(
              img.getAttribute('src') || img.getAttribute('data-src') || ''
            );
          }
        }

        if (chosen) {
          out.push(chosen);
        }
      }

      // 2) Fallback: plain <img> tags that might not be wrapped in <picture>.
      const imgs = Array.from(document.querySelectorAll('img'));
      for (const img of imgs) {
        const candidate = normalize(
          img.getAttribute('src') || img.getAttribute('data-src') || ''
        );
        if (candidate) {
          out.push(candidate);
        }
      }

      // De-duplicate while preserving order.
      const seen = new Set();
      const unique = [];
      for (const u of out) {
        if (!seen.has(u)) {
          seen.add(u);
          unique.push(u);
        }
      }

      return unique;
    });

    // Some pages may contain listing-images for other vehicles (e.g. recommendations).
    // Filter to only keep URLs that share the same listing id as the first image.
    let filtered = urls;
    if (urls.length > 0) {
      const m = urls[0].match(/listing-images\/([^_/]+)_/);
      if (m && m[1]) {
        const mainId = m[1];
        filtered = urls.filter((u) => u.includes(`listing-images/${mainId}_`));
      }
    }

    await browser.close();
    process.stdout.write(JSON.stringify(filtered));
  } catch {
    await browser.close();
    process.stdout.write(JSON.stringify([]));
  }
}

main().catch(() => {
  // On error, just return empty array; PHP side treats as "no extra images".
  process.stdout.write(JSON.stringify([]));
});


