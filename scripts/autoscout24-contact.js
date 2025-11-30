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

    // Try to click the "Mostra numero" button - prioritize by ID selector first
    const triggerSelectors = [
      '#call-desktop-button', // Specific ID from user's example
      'button#call-desktop-button',
      'button:has-text("Mostra numero")',
      'button:has-text("Mostra numero di telefono")',
      'a:has-text("Mostra numero")',
      'a:has-text("Mostra numero di telefono")',
      'button[aria-label*="numero"]',
      'a[aria-label*="numero"]',
      '[data-cs-mask="true"]:has-text("Mostra numero")', // Match by data attribute and text
    ];

    let buttonClicked = false;
    let buttonAlreadyRevealed = false;
    
    // First, check if the button is already revealed (it's an <a> tag with tel: href)
    try {
      const existingPhoneLink = await page.locator('#call-desktop-button[href^="tel:"]').first();
      if (await existingPhoneLink.isVisible({ timeout: 2000 }).catch(() => false)) {
        buttonAlreadyRevealed = true;
        process.stderr.write('Phone button already revealed, skipping click\n');
      }
    } catch (err) {
      // Continue to try clicking
    }

    if (!buttonAlreadyRevealed) {
      for (const sel of triggerSelectors) {
        try {
          const locator = page.locator(sel).first();
          const isVisible = await locator.isVisible({ timeout: 3000 }).catch(() => false);
          
          if (isVisible) {
            // Check if it's already a phone link (don't click if already revealed)
            const href = await locator.getAttribute('href').catch(() => null);
            if (href && href.startsWith('tel:')) {
              buttonAlreadyRevealed = true;
              break;
            }
            
            await locator.click({ timeout: 5000 });
            buttonClicked = true;
            
            process.stderr.write(`Successfully clicked button with selector: ${sel}\n`);
            
            // Wait for the button to transform into a phone link or for phone container to appear
            try {
              // Wait for the button to change to an <a> tag with tel: href
              await page.waitForSelector('#call-desktop-button[href^="tel:"]', { 
                timeout: 8000,
                state: 'visible' 
              }).catch(() => {
                // Alternative: wait for phone container
                return page.waitForSelector('.Contact_phonesContainer__afkGU', { 
                  timeout: 5000,
                  state: 'visible' 
                }).catch(() => {
                  // Try more generic selectors
                  return page.waitForSelector('[class*="phonesContainer"], [class*="Contact_phone"], a[href^="tel:"]', { 
                    timeout: 5000 
                  }).catch(() => null);
                });
              });
            } catch {
              // Container might not have that exact class, continue anyway
            }
            
            // Give additional time for JS to reveal the numbers after clicking
            await page.waitForTimeout(3000);
            break;
          }
        } catch (err) {
          // Ignore and try the next selector.
          process.stderr.write(`Failed to click button with selector ${sel}: ${err.message}\n`);
        }
      }
    }
    
    // If button was clicked or already revealed, wait a bit more for all numbers to fully load
    if (buttonClicked || buttonAlreadyRevealed) {
      await page.waitForTimeout(2000);
    }

    // After reveal, specifically look for phone numbers
    const contacts = await page.evaluate(() => {
      const result = {
        telLinks: [],
        whatsappLinks: [],
        phoneNumbers: [],
      };

      // FIRST PRIORITY: Check the call-desktop-button element (it becomes an <a> tag after clicking)
      const callButton = document.querySelector('#call-desktop-button');
      if (callButton) {
        const href = callButton.getAttribute('href');
        
        // Check if it's already a phone link (button was clicked and transformed)
        if (href && href.startsWith('tel:')) {
          const phoneNum = href.replace(/^tel:/i, '').trim();
          if (phoneNum) {
            result.telLinks.push(href);
            result.phoneNumbers.push(phoneNum);
            
            // Also try to get the displayed text from span if available
            const spanElement = callButton.querySelector('span');
            const textContent = spanElement ? spanElement.textContent?.trim() : callButton.textContent?.trim();
            
            if (textContent) {
              // Extract phone from text like "+39 011 - 19624710" or "+39 011-19624710"
              // Remove spaces, dashes, and normalize
              const normalizedText = textContent.replace(/[\s\-]/g, '').trim();
              if (normalizedText && normalizedText !== phoneNum && normalizedText.length >= 10) {
                // Only add if it looks like a valid phone number
                result.phoneNumbers.push(normalizedText);
              }
            }
          }
        }
      }

      // SECOND PRIORITY: Try to find the specific phone container
      const phoneContainer = document.querySelector('.Contact_phonesContainer__afkGU') ||
                            document.querySelector('[class*="phonesContainer"]') ||
                            document.querySelector('[class*="Contact_phone"]');

      if (phoneContainer) {
        const anchors = Array.from(phoneContainer.querySelectorAll('a[href^="tel:"]'));
        
        // Extract all phone numbers from tel: links in container
        for (const a of anchors) {
          const href = (a.getAttribute('href') || '').trim();
          if (href.startsWith('tel:')) {
            const phoneNum = href.replace(/^tel:/i, '').trim();
            if (phoneNum && !result.phoneNumbers.includes(phoneNum)) {
              result.telLinks.push(href);
              result.phoneNumbers.push(phoneNum);
            }
          }
        }
      }
      
      // THIRD PRIORITY: Look for any tel: links on the page (but only if we haven't found any yet)
      if (result.phoneNumbers.length === 0) {
        const allTelLinks = Array.from(document.querySelectorAll('a[href^="tel:"]'));
        for (const a of allTelLinks) {
          const href = (a.getAttribute('href') || '').trim();
          if (href.startsWith('tel:')) {
            const phoneNum = href.replace(/^tel:/i, '').trim();
            if (phoneNum && !result.phoneNumbers.includes(phoneNum)) {
              // Skip if it's a button element (might be the call button itself, already handled)
              const isCallButton = a.id === 'call-desktop-button';
              if (!isCallButton) {
                result.telLinks.push(href);
                result.phoneNumbers.push(phoneNum);
              }
            }
          }
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
        phone = uniquePhones[0];
        
        // Log to stderr for debugging
        if (uniquePhones.length > 1) {
          process.stderr.write(`Found ${uniquePhones.length} phone numbers: ${uniquePhones.join(', ')}\n`);
          process.stderr.write(`Using first: ${phone}\n`);
        } else {
          process.stderr.write(`Extracted phone number: ${phone}\n`);
        }
      }
    } else if (contacts && Array.isArray(contacts.telLinks) && contacts.telLinks.length > 0) {
      // Fallback: extract from tel: links if phoneNumbers array is empty
      const uniqueTels = [...new Set(contacts.telLinks)];
      if (uniqueTels.length > 0) {
        phone = uniqueTels[0].replace(/^tel:/i, '').trim();
        process.stderr.write(`Extracted phone from tel: link: ${phone}\n`);
      }
    } else {
      process.stderr.write('No phone numbers found after clicking "Mostra numero" button\n');
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



