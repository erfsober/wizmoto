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
    args: [
      '--no-sandbox',
      '--disable-dev-shm-usage',
      '--disable-blink-features=AutomationControlled',
      '--disable-features=IsolateOrigins,site-per-process',
    ],
  });

  const page = await browser.newPage({
    userAgent:
      'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
  });
  
  // Set additional headers to appear more like a real browser
  await page.setExtraHTTPHeaders({
    'Accept-Language': 'it-IT,it;q=0.9,en-US;q=0.8,en;q=0.7',
    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    'Accept-Encoding': 'gzip, deflate, br',
    'Connection': 'keep-alive',
    'Upgrade-Insecure-Requests': '1',
  });
  
  // Remove webdriver detection
  await page.addInitScript(() => {
    Object.defineProperty(navigator, 'webdriver', {
      get: () => undefined,
    });
  });

  let phone = null;
  let whatsapp = null;

  try {
    // Navigate to the page - use domcontentloaded (faster than networkidle)
    process.stderr.write(`Navigating to: ${url}\n`);
    try {
      await page.goto(url, {
        waitUntil: 'domcontentloaded',
        timeout: 60000, // 60 seconds should be enough
      });
      process.stderr.write(`✓ Page navigation successful\n`);
    } catch (err) {
      process.stderr.write(`⚠ Navigation warning: ${err.message}\n`);
      process.stderr.write(`Continuing anyway - page may have partially loaded...\n`);
      // Wait a bit for any ongoing loading
      await page.waitForTimeout(5000);
    }
    
    // Wait for page to be fully interactive
    await page.waitForTimeout(3000);
    
    // Verify page loaded
    const pageTitle = await page.title().catch(() => '');
    const currentUrl = page.url();
    process.stderr.write(`Page title: ${pageTitle.substring(0, 60)}\n`);
    process.stderr.write(`Current URL: ${currentUrl.substring(0, 80)}\n`);

    // Try to click the "Mostra numero" button - prioritize by ID selector first
    const triggerSelectors = [
      '#call-desktop-button', // Specific ID from user's example
      'button#call-desktop-button',
      'button:has-text("Mostra numero")',
      'a:has-text("Mostra numero")',
      'button:has-text("Mostra numero di telefono")',
      'a:has-text("Mostra numero di telefono")',
      '[data-cs-mask="true"]:has-text("Mostra numero")', // Match by data attribute and text
      'button[aria-label*="numero"]',
      'a[aria-label*="numero"]',
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
          const isVisible = await locator.isVisible({ timeout: 5000 }).catch(() => false);
          
          if (isVisible) {
            // Scroll to button to ensure it's in view
            await locator.scrollIntoViewIfNeeded();
            await page.waitForTimeout(500);
            
            // Check if it's already a phone link (don't click if already revealed)
            const href = await locator.getAttribute('href').catch(() => null);
            if (href && href.startsWith('tel:')) {
              buttonAlreadyRevealed = true;
              process.stderr.write(`Button already has tel: link: ${href}\n`);
              break;
            }
            
            // Try to click the button
            await locator.click({ timeout: 5000, force: false });
            buttonClicked = true;
            
            process.stderr.write(`Successfully clicked button with selector: ${sel}\n`);
            
            // Wait for the button to transform into a phone link or for phone container to appear
            try {
              // Wait for the button to change to an <a> tag with tel: href
              await page.waitForSelector('#call-desktop-button[href^="tel:"]', { 
                timeout: 10000,
                state: 'visible' 
              }).then(() => {
                process.stderr.write('Phone link appeared after click\n');
              }).catch(() => {
                // Alternative: wait for phone container
                return page.waitForSelector('.Contact_phonesContainer__afkGU', { 
                  timeout: 8000,
                  state: 'visible' 
                }).then(() => {
                  process.stderr.write('Phone container appeared after click\n');
                }).catch(() => {
                  // Try more generic selectors
                  return page.waitForSelector('[class*="phonesContainer"], [class*="Contact_phone"], a[href^="tel:"]', { 
                    timeout: 5000 
                  }).then(() => {
                    process.stderr.write('Generic phone selector found after click\n');
                  }).catch(() => {
                    process.stderr.write('No phone elements found after click - continuing anyway\n');
                  });
                });
              });
            } catch {
              // Container might not have that exact class, continue anyway
              process.stderr.write('Error waiting for phone elements - continuing\n');
            }
            
            // Give additional time for JS to reveal the numbers after clicking
            await page.waitForTimeout(5000);
            break;
          }
        } catch (err) {
          // Ignore and try the next selector.
          process.stderr.write(`Failed to click button with selector ${sel}: ${err.message}\n`);
        }
      }
      
      // If no button was clicked, log warning
      if (!buttonClicked && !buttonAlreadyRevealed) {
        process.stderr.write('WARNING: No "Mostra numero" button was found or clicked!\n');
        process.stderr.write('Will try to extract phone numbers from page anyway...\n');
      }
    }
    
    // If button was clicked or already revealed, wait a bit more for all numbers to fully load
    if (buttonClicked || buttonAlreadyRevealed) {
      await page.waitForTimeout(5000); // Increased wait time
      
      // Try clicking again if still no phone visible
      if (!buttonAlreadyRevealed) {
        try {
          const phoneVisible = await page.locator('#call-desktop-button[href^="tel:"]').isVisible({ timeout: 1000 }).catch(() => false);
          if (!phoneVisible) {
            process.stderr.write('Phone not visible after click, trying again...\n');
            // Try clicking one more time
            const retryButton = await page.locator('button:has-text("Mostra numero"), #call-desktop-button').first();
            if (await retryButton.isVisible({ timeout: 2000 }).catch(() => false)) {
              await retryButton.click();
              await page.waitForTimeout(3000);
            }
          }
        } catch (err) {
          process.stderr.write(`Retry click failed: ${err.message}\n`);
        }
      }
    }

    // Debug: Check what buttons are on the page
    const buttonInfo = await page.evaluate(() => {
      const buttons = Array.from(document.querySelectorAll('button, a'));
      return buttons
        .filter(b => b.textContent && b.textContent.includes('Mostra'))
        .map(b => ({
          tag: b.tagName,
          id: b.id || '',
          text: b.textContent?.trim().substring(0, 50) || '',
          href: b.href || b.getAttribute('href') || '',
          classes: b.className || ''
        }));
    });
    
    if (buttonInfo && buttonInfo.length > 0) {
      process.stderr.write(`Found ${buttonInfo.length} buttons with "Mostra" text:\n`);
      buttonInfo.forEach((btn, idx) => {
        process.stderr.write(`  ${idx + 1}. ${btn.tag}#${btn.id || 'no-id'} - "${btn.text}" - href: ${btn.href}\n`);
      });
    } else {
      process.stderr.write('No buttons with "Mostra" text found on page\n');
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
        if (href && href.startsWith('tel:')) {
          const phoneNum = href.replace(/^tel:/i, '').trim();
          if (phoneNum) {
            result.telLinks.push(href);
            result.phoneNumbers.push(phoneNum);
            // Also try to get the displayed text if available
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
        const allTelLinks = Array.from(document.querySelectorAll('a[href^="tel:"], button[href^="tel:"]'));
        for (const a of allTelLinks) {
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
      
      // FOURTH PRIORITY: Look for phone numbers in text content (as last resort)
      if (result.phoneNumbers.length === 0) {
        // Look for Italian phone patterns: +39 xxx xxxxxxx or similar
        const textContent = document.body.textContent || '';
        const phoneRegex = /(?:\+39|0039)?\s*[0-9]{2,3}\s*[0-9]{6,7}/g;
        const matches = textContent.match(phoneRegex);
        if (matches && matches.length > 0) {
          // Try to find the most likely phone number (longest, contains +39 or starts with common prefixes)
          const cleaned = matches
            .map(m => m.replace(/\s+/g, '').trim())
            .filter(m => m.length >= 9 && m.length <= 15)
            .filter(m => m.startsWith('+39') || m.startsWith('0039') || /^[0-9]{9,}$/.test(m));
          
          if (cleaned.length > 0) {
            // Prefer numbers starting with +39
            const preferred = cleaned.find(m => m.startsWith('+39')) || cleaned[0];
            if (preferred) {
              result.phoneNumbers.push(preferred);
            }
          }
        }
      }

      // Look for WhatsApp links (check entire page)
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
        raw.match(/send\/([0-9+]+)/i) ||
        raw.match(/whatsapp\.com\/send\?phone=([0-9+]+)/i);
      
      if (match && match[1]) {
        whatsapp = match[1].trim();
        process.stderr.write(`Extracted WhatsApp number: ${whatsapp}\n`);
      } else {
        whatsapp = raw;
        process.stderr.write(`WhatsApp link (raw): ${whatsapp}\n`);
      }
    }

    await browser.close();
    process.stdout.write(JSON.stringify({ phone, whatsapp }));
  } catch (err) {
    process.stderr.write(`Error in contact script: ${err.message}\n`);
    process.stderr.write(`Stack: ${err.stack}\n`);
    await browser.close();
    process.stdout.write(JSON.stringify({ phone: null, whatsapp: null }));
  }
}

main().catch((err) => {
  // On error, log it and return nulls
  process.stderr.write(`Fatal error in contact script: ${err.message}\n`);
  if (err.stack) {
    process.stderr.write(`Stack: ${err.stack}\n`);
  }
  process.stdout.write(JSON.stringify({ phone: null, whatsapp: null }));
});



