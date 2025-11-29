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
      'button[aria-label*="numero"]',
      'a[aria-label*="numero"]',
    ];

    let buttonClicked = false;
    for (const sel of triggerSelectors) {
      const locator = page.locator(sel);
      if (await locator.first().isVisible({ timeout: 3000 }).catch(() => false)) {
        try {
          await locator.first().click({ timeout: 5000 });
          buttonClicked = true;
          
          // Wait for phone container to appear with multiple selector strategies
          try {
            // Wait for the specific container class
            await page.waitForSelector('.Contact_phonesContainer__afkGU', { 
              timeout: 5000,
              state: 'visible' 
            }).catch(() => {
              // Try alternative selectors
              return page.waitForSelector('[class*="phonesContainer"], [class*="Contact_phone"], a[href^="tel:"]', { 
                timeout: 5000 
              }).catch(() => null);
            });
          } catch {
            // Container might not have that exact class, continue anyway
          }
          
          // Give additional time for JS to reveal the numbers after container appears
          await page.waitForTimeout(2000);
          break;
        } catch (err) {
          // Ignore and try the next selector.
          process.stderr.write(`Failed to click button with selector ${sel}: ${err.message}\n`);
        }
      }
    }
    
    // If button was clicked, wait a bit more for all numbers to load
    if (buttonClicked) {
      await page.waitForTimeout(1000);
    }

    // After reveal, specifically look for phone numbers in the contact container
    const contacts = await page.evaluate(() => {
      const result = {
        telLinks: [],
        whatsappLinks: [],
        phoneNumbers: [],
      };

      // First, try to find the specific phone container (only use numbers from this container)
      const phoneContainer = document.querySelector('.Contact_phonesContainer__afkGU') ||
                            document.querySelector('[class*="phonesContainer"]') ||
                            document.querySelector('[class*="Contact_phone"]');

      // Only get tel: links from the container - don't search entire page to avoid fake numbers
      if (!phoneContainer) {
        // If no container found, return empty (we don't want fake numbers from page text)
        return result;
      }

      const anchors = Array.from(phoneContainer.querySelectorAll('a[href^="tel:"]'));

      // Extract all phone numbers from tel: links
      for (const a of anchors) {
        const href = (a.getAttribute('href') || '').trim();
        if (href.startsWith('tel:')) {
          const phoneNum = href.replace(/^tel:/i, '').trim();
          result.telLinks.push(href);
          result.phoneNumbers.push(phoneNum);
        }
      }

      // Also look for WhatsApp links
      const allAnchors = Array.from(document.querySelectorAll('a[href]'));
      for (const a of allAnchors) {
        const href = (a.getAttribute('href') || '').trim();
        if (!href) continue;

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

    // Use all phone numbers found (deduplicate)
    if (contacts && Array.isArray(contacts.phoneNumbers) && contacts.phoneNumbers.length > 0) {
      // Remove duplicates and filter out empty values
      const uniquePhones = [...new Set(contacts.phoneNumbers.filter(p => p && p.trim()))];
      if (uniquePhones.length > 0) {
        // Use the first phone number as primary
        // For multiple numbers, we'll return the first one (PHP can be updated later to handle multiple)
        phone = uniquePhones[0];
        // Log to stderr if multiple numbers found for debugging
        if (uniquePhones.length > 1) {
          process.stderr.write(`Found ${uniquePhones.length} phone numbers: ${uniquePhones.join(', ')}\n`);
          process.stderr.write(`Using first: ${phone}\n`);
        }
      }
    } else if (contacts && Array.isArray(contacts.telLinks) && contacts.telLinks.length > 0) {
      // Fallback: extract from tel: links if phoneNumbers array is empty
      const uniqueTels = [...new Set(contacts.telLinks)];
      if (uniqueTels.length > 0) {
        phone = uniqueTels[0].replace(/^tel:/i, '').trim();
      }
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

    // Only extract phone from contact container - don't use page text fallback
    // to avoid getting fake/incorrect numbers. Only real numbers shown after
    // clicking "Mostra numero" should be used.

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



