#!/usr/bin/env node

/**
 * Headless helper to extract the revealed phone / WhatsApp contact from
 * a single Autoscout24 ad or dealer page by clicking "Mostra numero".
 *
 * Usage:
 *   node scripts/autoscout24-contact.js "<url>"
 *
 * Prints a JSON object to stdout:
 *   { "phone": "...", "whatsapp": "..." }
 *
 * NOTE: Requires Playwright:
 *   npm install playwright
 */

import { chromium } from 'playwright';

async function main() {
  const url = process.argv[2];
  if (!url) {
    process.stdout.write(JSON.stringify({ phone: null, whatsapp: null }));
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

  let phone = null;
  let whatsapp = null;

  try {
    await page.goto(url, {
      waitUntil: 'domcontentloaded',
      timeout: 60000,
    });

    // Try to click any "Mostra numero" / "Mostra numero di telefono" button/link.
    const triggerSelectors = [
      'button:has-text("Mostra numero")',
      'button:has-text("Mostra numero di telefono")',
      'a:has-text("Mostra numero")',
      'a:has-text("Mostra numero di telefono")',
    ];

    for (const sel of triggerSelectors) {
      const locator = page.locator(sel);
      if (await locator.first().isVisible().catch(() => false)) {
        try {
          await locator.first().click({ timeout: 5000 });
          // Give time for JS to reveal the number.
          await page.waitForTimeout(2000);
          break;
        } catch {
          // Ignore and try the next selector.
        }
      }
    }

    // After reveal, look for tel: links and WhatsApp links.
    const contacts = await page.evaluate(() => {
      const result = {
        telLinks: [],
        whatsappLinks: [],
      };

      const anchors = Array.from(document.querySelectorAll('a[href]'));
      for (const a of anchors) {
        const href = (a.getAttribute('href') || '').trim();
        if (!href) continue;

        if (href.startsWith('tel:')) {
          result.telLinks.push(href);
        }

        const h = href.toLowerCase();
        if (
          h.includes('whatsapp') ||
          h.includes('wa.me') ||
          h.includes('api.whatsapp.com')
        ) {
          result.whatsappLinks.push(href);
        }
      }

      return result;
    });

    if (contacts && Array.isArray(contacts.telLinks) && contacts.telLinks.length > 0) {
      // Take the first tel: link and strip the scheme.
      const raw = contacts.telLinks[0];
      phone = raw.replace(/^tel:/i, '').trim();
    }

    if (
      contacts &&
      Array.isArray(contacts.whatsappLinks) &&
      contacts.whatsappLinks.length > 0
    ) {
      const raw = contacts.whatsappLinks[0];
      // Try to extract a phone number from common WhatsApp URL formats.
      const match =
        raw.match(/phone=([0-9+]+)/i) ||
        raw.match(/wa\.me\/([0-9+]+)/i) ||
        raw.match(/send\/([0-9+]+)/i);
      if (match && match[1]) {
        whatsapp = match[1].trim();
      } else {
        whatsapp = raw;
      }
    }

    await browser.close();
    process.stdout.write(JSON.stringify({ phone, whatsapp }));
  } catch {
    await browser.close();
    process.stdout.write(JSON.stringify({ phone: null, whatsapp: null }));
  }
}

main().catch(() => {
  // On error, just return nulls (PHP side treats as "no contact").
  process.stdout.write(JSON.stringify({ phone: null, whatsapp: null }));
});


