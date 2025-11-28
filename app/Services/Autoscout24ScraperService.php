<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Autoscout24ScraperService
{
    /**
     * Base site and search page.
     */
    private string $baseUrl = 'https://www.autoscout24.it';
    private string $searchUrl = 'https://www.autoscout24.it/lst-moto?sort=standard&desc=0&ustate=N%2CU&atype=B&cy=I&cat=&damaged_listing=exclude&source=homepage_search-mask';

    /**
     * User agent used for HTTP requests.
     */
    private string $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';

    /**
     * Scrape the search page and return up to $limit ad URLs.
     *
     * @return array<int, string>  List of ad URLs
     */
    public function scrapePage(int $limit = 10): array
    {

        // First try using the headless Node scraper (Playwright).
        $urls = $this->scrapePageWithHeadless($limit);

        if (! empty($urls)) {

            return $urls;
        }

        // Fallback: HTML-based extraction with pagination support.
        return $this->scrapePageWithPagination($limit);
    }

    /**
     * Scrape multiple pages using HTTP requests with pagination.
     *
     * @return array<int, string>  List of ad URLs
     */
    private function scrapePageWithPagination(int $limit): array
    {
        $allUrls = [];
        $currentPage = 1;
        $maxPages = 50;
        $searchId = null;

        while (count($allUrls) < $limit && $currentPage <= $maxPages) {
            // Build URL for current page
            $pageUrl = $this->buildPageUrl($currentPage, $searchId);
            
            Log::info("Fetching page {$currentPage} from: {$pageUrl}");

            $html = $this->fetchHtml($pageUrl);

            if ($html === null) {
                Log::warning("Failed to fetch page {$currentPage}");
                break;
            }

            // Extract search_id from first page if not set
            if ($currentPage === 1 && $searchId === null) {
                $searchId = $this->extractSearchId($html);
                if ($searchId) {
                    Log::info("Extracted search_id: {$searchId}");
                }
            }

            // Extract URLs from current page
            $pageUrls = $this->extractAdUrls($html, $limit - count($allUrls));

            if (empty($pageUrls)) {
                Log::info("No URLs found on page {$currentPage}, stopping pagination");
                break;
            }

            // Add new URLs (avoid duplicates)
            $newUrls = array_diff($pageUrls, $allUrls);
            $allUrls = array_merge($allUrls, $newUrls);

            Log::info("Page {$currentPage}: Found " . count($pageUrls) . " URLs, Total: " . count($allUrls) . "/{$limit}");

            // Check if we have enough URLs
            if (count($allUrls) >= $limit) {
                break;
            }

            // Check if there's a next page by looking for pagination indicators
            if (!$this->hasNextPage($html)) {
                Log::info("No next page found, stopping pagination");
                break;
            }

            $currentPage++;
            
            // Small delay between pages to avoid rate limiting
            sleep(1);
        }

        return array_slice($allUrls, 0, $limit);
    }

    /**
     * Build URL for a specific page number.
     */
    private function buildPageUrl(int $pageNum, ?string $searchId = null): string
    {
        $urlParts = parse_url($this->searchUrl);
        $queryParams = [];
        
        // Parse existing query parameters
        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $queryParams);
        }
        
        // Update page number
        $queryParams['page'] = $pageNum;
        
        // Add search_id if provided
        if ($searchId !== null) {
            $queryParams['search_id'] = $searchId;
        }
        
        // Add source parameter for pagination
        if (!isset($queryParams['source']) && $pageNum > 1) {
            $queryParams['source'] = 'listpage_pagination';
        }

        // Rebuild URL
        $scheme = $urlParts['scheme'] ?? 'https';
        $host = $urlParts['host'] ?? '';
        $path = $urlParts['path'] ?? '';
        $query = http_build_query($queryParams);

        return "{$scheme}://{$host}{$path}?{$query}";
    }

    /**
     * Extract search_id from HTML (might be in URL or in page).
     */
    private function extractSearchId(string $html): ?string
    {
        // Try to find search_id in pagination links (most reliable)
        if (preg_match('/href=["\']([^"\']*[?&]search_id=([a-z0-9]+)[^"\']*)["\']/i', $html, $matches)) {
            return $matches[2];
        }

        // Try to find it in URL parameters in the HTML
        if (preg_match('/[?&]search_id=([a-z0-9]+)/i', $html, $matches)) {
            return $matches[1];
        }

        // Try to find it in JavaScript/JSON data
        if (preg_match('/["\']search_id["\']\s*:\s*["\']([a-z0-9]+)["\']/i', $html, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Check if HTML indicates there's a next page.
     */
    private function hasNextPage(string $html): bool
    {
        // Check if next button exists and is not disabled
        if (preg_match('/button[^>]*aria-label[^>]*successiva[^>]*disabled/i', $html)) {
            return false;
        }

        // Check for next button that's not disabled
        if (preg_match('/<button[^>]*aria-label[^>]*successiva[^>]*(?!disabled)/i', $html)) {
            return true;
        }

        // Check for pagination showing current page vs total pages
        if (preg_match('/(\d+)\s*\/\s*(\d+)/', $html, $matches)) {
            $currentPage = (int) $matches[1];
            $totalPages = (int) $matches[2];
            return $currentPage < $totalPages;
        }

        // If we can't determine, assume there might be more pages
        return true;
    }

    /**
     * Scrape a single ad page and return basic data.
     *
     * @return array<string, mixed>|null
     */
    public function scrapeAd(string $url): ?array
    {

        $html = $this->fetchHtml($url);

        if ($html === null) {
            return null;
        }

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        // Title: og:title or <h1>.
        $titleNode = $xpath->query('//meta[@property="og:title"]')->item(0)
            ?: $xpath->query('//h1')->item(0);

        $title = null;
        if ($titleNode instanceof \DOMElement) {
            $title = $titleNode->hasAttribute('content')
                ? $titleNode->getAttribute('content')
                : $titleNode->textContent;
        }

        // Price: common price containers.
        $priceNode = $xpath->query('//*[contains(@class,"price") or @data-item-name="price" or @data-testid="price-main"]')->item(0);
        $price = $priceNode instanceof \DOMElement ? trim($priceNode->textContent) : null;

        // Description: meta description or main description block.
        $descriptionNode = $xpath->query('//meta[@name="description"]')->item(0)
            ?: $xpath->query('//*[contains(@class,"description") or @data-item-name="description"]')->item(0);

        $description = null;
        if ($descriptionNode instanceof \DOMElement) {
            $description = $descriptionNode->hasAttribute('content')
                ? $descriptionNode->getAttribute('content')
                : $descriptionNode->textContent;
        }

        // Seller notes: the large dealer-written block, if present.
        $sellerNotes = null;
        $sellerNotesNode = $xpath->query('//*[@id="sellerNotesSection"]')->item(0);
        if ($sellerNotesNode instanceof \DOMElement) {
            $text = trim($sellerNotesNode->textContent);
            if ($text !== '') {
                $sellerNotes = $text;
                // Prefer the detailed seller notes as description when available.
                $description = $sellerNotes;
            }
        }

        // Images: og:image first, then <img>.
        $images = [];

        $ogImageNodes = $xpath->query('//meta[@property="og:image"]');
        if ($ogImageNodes !== false) {
            foreach ($ogImageNodes as $ogImage) {
                if (! $ogImage instanceof \DOMElement) {
                    continue;
                }

                $content = trim($ogImage->getAttribute('content'));
                if ($content !== '') {
                    $images[] = $this->buildFullImageUrl($content);
                }
            }
        }

        if (empty($images)) {
            $imgNodes = $xpath->query('//img[@src or @data-src]');

            if ($imgNodes !== false) {
                foreach ($imgNodes as $img) {
                    if (! $img instanceof \DOMElement) {
                        continue;
                    }

                    $src = $img->getAttribute('data-src') ?: $img->getAttribute('src');
                    $src = trim($src);

                    if ($src !== '') {
                        $images[] = $this->buildFullImageUrl($src);
                    }
                }
            }
        }

        // Try to extract structured meta information from inline JSON blobs.
        $meta = [
            'brand'            => null, // human-readable brand name, e.g. "Malaguti"
            'model'            => null, // human-readable model name, e.g. "Madison 250"
            'brand_code'       => null, // internal Autoscout24 brand id
            'model_code'       => null, // internal Autoscout24 model id
            'city'             => null, // e.g. "Torino_To"
            'zip'              => null, // e.g. "IT10132"
            'dealer_id'        => null, // Autoscout24 dealer ID
            'dealer_name'      => null, // e.g. "Magic Bike srl"
            'dealer_address'   => null, // e.g. "CORSO CASALE 479, 10132 Torino - To, IT"
            'dealer_page_url'  => null, // e.g. "https://www.autoscout24.it/concessionari/magic-bike-srl/chi-siamo"
            'seller_type'      => null, // 'dealer' or 'private'
            'fuel_code'        => null, // e.g. 'B' (Benzina), 'D' (Diesel), 'E' (Electric)
            'gear_code'        => null, // e.g. 'M' (Manual)
            'condition'        => null, // e.g. 'new', 'used'
            'power_kw'         => null, // numeric kW if available
            'power_cv'         => null, // numeric CV/HP if available
            'displacement_cc'  => null, // engine displacement in cc
            'mileage_km'       => null, // total mileage in km
            'reg_month'        => null, // first registration month (string/int)
            'reg_year'         => null, // first registration year (string/int)
            'body_type'        => null, // e.g. "Scooter"
            'motor_marches'    => null, // number of gears
            'motor_cylinders'  => null, // number of cylinders
            'contact_name'     => null, // salesperson contact (if present)
            'contact_phone'    => null,
            'contact_email'    => null,
        ];

        if (preg_match('/\{"sthp":.*?"cockpit":".*?"\}/s', $html, $m)) {
            $json = $m[0];
            $decoded = json_decode($json, true);

            if (is_array($decoded)) {
                $meta['brand']        = $decoded['stmak'] ?? null;
                $meta['model']        = $decoded['stmod'] ?? ($decoded['model'] ?? null);
                $meta['brand_code']   = $decoded['make'] ?? null;
                $meta['model_code']   = $decoded['model'] ?? null;
                $meta['city']         = $decoded['city'] ?? null;
                $meta['zip']          = $decoded['zip'] ?? null;
                $meta['dealer_id']    = $decoded['did'] ?? null;
                $meta['seller_type']  = $decoded['ad'] ?? null;
                $meta['fuel_code']    = $decoded['fuel'] ?? null;
                $meta['gear_code']    = $decoded['gear'] ?? null;
                $meta['condition']    = $decoded['fr'] ?? null;

                if (isset($decoded['stkw']) && is_numeric($decoded['stkw'])) {
                    $meta['power_kw'] = (int) $decoded['stkw'];
                }

                if (isset($decoded['sthp']) && is_numeric($decoded['sthp'])) {
                    $meta['power_cv'] = (int) $decoded['sthp'];
                }

                if (isset($decoded['stmil']) && is_numeric($decoded['stmil'])) {
                    $meta['mileage_km'] = (int) $decoded['stmil'];
                }

                if (isset($decoded['stmon']) && $decoded['stmon'] !== '') {
                    $meta['reg_month'] = (string) $decoded['stmon'];
                }

                if (isset($decoded['styea']) && $decoded['styea'] !== '') {
                    $meta['reg_year'] = (string) $decoded['styea'];
                }
            }
        }

        // Technical details section: parse displacement (Cilindrata), gears, cylinders, etc.
        $techDtNodes = $xpath->query('//*[@id="technical-details-section"]//dt');
        $techDdNodes = $xpath->query('//*[@id="technical-details-section"]//dd');
        if ($techDtNodes !== false && $techDdNodes !== false) {
            $count = min($techDtNodes->length, $techDdNodes->length);
            for ($i = 0; $i < $count; $i++) {
                $label = trim($techDtNodes->item($i)?->textContent ?? '');
                $value = trim($techDdNodes->item($i)?->textContent ?? '');

                if ($label === '' || $value === '') {
                    continue;
                }

                // Cilindrata: e.g. "660 cm³" → 660
                if (stripos($label, 'Cilindrata') !== false) {
                    if (preg_match('/([0-9][0-9\.\s]*)\s*cm/i', $value, $mDisp)) {
                        $num = preg_replace('/[^\d]/', '', $mDisp[1]);
                        if ($num !== '') {
                            $meta['displacement_cc'] = (int) $num;
                        }
                    }
                    continue;
                }

                // Number of gears (Marce / Gears): value like "6" or "6 marce".
                $lowerLabel = mb_strtolower($label);
                if (
                    str_contains($lowerLabel, 'marce') ||
                    str_contains($lowerLabel, 'marches') ||
                    str_contains($lowerLabel, 'gears')
                ) {
                    if (preg_match('/\d+/', $value, $mG)) {
                        $meta['motor_marches'] = (int) $mG[0];
                    }
                    continue;
                }

                // Cylinders (Cilindri / Cylinders): value like "2" or "2 cilindri".
                if (
                    str_contains($lowerLabel, 'cilindri') ||
                    str_contains($lowerLabel, 'cylinders')
                ) {
                    if (preg_match('/\d+/', $value, $mC)) {
                        $meta['motor_cylinders'] = (int) $mC[0];
                    }
                    continue;
                }
            }
        }

        // Dati di base: Carrozzeria (body type), if present.
        $bodyNode = $xpath->query('//dt[normalize-space()="Carrozzeria"]/following-sibling::dd[1]')->item(0);
        if ($bodyNode instanceof \DOMElement) {
            $bodyText = trim($bodyNode->textContent);
            if ($bodyText !== '') {
                $meta['body_type'] = $bodyText; // e.g. "Scooter"
            }
        }

        // Try to extract dealer contact info from seller notes HTML block.
        // Pattern example:
        // <strong>Ansprechpartner:</strong><br>Julian Adolphi<br>07121 95 93 22<br>julian...@...<br>
        if (preg_match(
            '/Ansprechpartner:<\/strong><br>\s*([^<]+)<br>\s*([^<]+)<br>\s*([^<]+)<br>/i',
            $html,
            $m
        )) {
            $meta['contact_name']  = trim($m[1]);
            $meta['contact_phone'] = trim($m[2]);
            $meta['contact_email'] = trim($m[3]);
        }

        // Dealer name: from RatingsAndCompanyName_dealer block.
        $dealerNameNode = $xpath->query('//*[contains(@class,"RatingsAndCompanyName_dealer")]//div[@data-cs-mask][1]')->item(0);
        if ($dealerNameNode instanceof \DOMElement) {
            $dealerName = trim($dealerNameNode->textContent);
            if ($dealerName !== '') {
                $meta['dealer_name'] = $dealerName;
            }
        }

        // Dealer address: from Department_departmentContainer link (Google Maps).
        $dealerAddressNode = $xpath->query('//*[contains(@class,"Department_departmentContainer")]//a[1]')->item(0);
        if ($dealerAddressNode instanceof \DOMElement) {
            $addr = trim(preg_replace("/\s+/", ' ', $dealerAddressNode->textContent));
            if ($addr !== '') {
                $meta['dealer_address'] = $addr;
            }
        }

        // Dealer page URL: anchor around dealer name usually links to "/concessionari/.../chi-siamo".
        $dealerLinkNode = $xpath->query('//*[contains(@class,"RatingsAndCompanyName_dealer")]//a[@href][1]')->item(0);
        if ($dealerLinkNode instanceof \DOMElement) {
            $href = trim($dealerLinkNode->getAttribute('href'));
            if ($href !== '') {
                if (str_starts_with($href, 'http')) {
                    $meta['dealer_page_url'] = $href;
                } else {
                    $meta['dealer_page_url'] = 'https://www.autoscout24.it' . (str_starts_with($href, '/') ? $href : '/' . $href);
                }
            }
        }

        // Equipment: list of bullet items from the equipment section, if present.
        $equipment = [];
        $equipmentNodes = $xpath->query('//*[@id="equipment-section"]//dd//li');
        if ($equipmentNodes !== false) {
            foreach ($equipmentNodes as $li) {
                if (! $li instanceof \DOMElement) {
                    continue;
                }
                $label = trim($li->textContent);
                if ($label !== '') {
                    $equipment[] = $label;
                }
            }
        }

        // Color: specific color name from the color section, if present.
        $color = null;
        $colorNode = $xpath->query('//*[@id="color-section"]//dd')->item(0);
        if ($colorNode instanceof \DOMElement) {
            $colorText = trim($colorNode->textContent);
            if ($colorText !== '') {
                $color = $colorText;
            }
        }

        // Let downstream importer know this ad URL for possible headless contact scraping.
        $meta['first_ad_url'] = $url;

        $data = [
            'url'          => $url,
            'title'        => $title !== null ? trim($title) : null,
            'price'        => $price,
            'description'  => $description !== null ? trim($description) : null,
            'images'       => array_values(array_unique(array_filter($images))),
            'meta'         => $meta,
            'equipment'    => array_values(array_unique($equipment)),
            'color'        => $color,
            'seller_notes' => $sellerNotes,
        ];


        return $data;
    }

    /**
     * Low-level HTTP fetch with retry logic.
     */
    private function fetchHtml(string $url, int $retries = 3): ?string
    {
        $attempt = 0;

        while ($attempt < $retries) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => $this->userAgent,
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'it-IT,it;q=0.9,en-US;q=0.8,en;q=0.7',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Referer' => 'https://www.autoscout24.it/',
                    'Connection' => 'keep-alive',
                ])
                ->timeout(30)
                ->retry(2, 1000)
                ->get($url);

                if (! $response->successful()) {
                    $attempt++;
                    if ($attempt >= $retries) {
                        Log::warning("Failed to fetch HTML for {$url}: HTTP {$response->status()}");
                        return null;
                    }
                    // Wait before retry (exponential backoff)
                    sleep(min($attempt, 3));
                    continue;
                }

                $body = $response->body();
                
                // Check if we got a valid HTML page (not a redirect or error page)
                if (empty($body) || strlen($body) < 500) {
                    $attempt++;
                    if ($attempt >= $retries) {
                        Log::warning("Received empty or too short HTML for {$url}");
                        return null;
                    }
                    sleep(min($attempt, 3));
                    continue;
                }

                return $body;
            } catch (\Throwable $e) {
                $attempt++;
                if ($attempt >= $retries) {
                    Log::error("Exception fetching HTML for {$url}: {$e->getMessage()}");
                    return null;
                }
                // Wait before retry (exponential backoff)
                sleep(min($attempt, 3));
            }
        }

        return null;
    }

    /**
     * Fetch HTML using headless browser (Playwright) for pages that require JavaScript.
     *
     * @return string|null
     */
    private function fetchHtmlWithHeadless(string $url): ?string
    {
        $scriptPath = base_path('scripts/autoscout24-ad-html.js');

        if (! file_exists($scriptPath)) {
            Log::warning("Headless ad HTML script not found at {$scriptPath}");
            return null;
        }

        $command = sprintf(
            'node %s %s 2>&1',
            escapeshellarg($scriptPath),
            escapeshellarg($url)
        );

        $output = shell_exec($command);

        if ($output === null || trim($output) === '') {
            Log::warning("Headless browser returned empty output for ad URL {$url}");
            return null;
        }

        // Check if there was an error (script writes errors to stderr, which goes to output with 2>&1)
        if (str_contains(strtolower($output), 'error:') || str_contains(strtolower($output), 'fatal error:')) {
            Log::warning("Headless browser error for {$url}: " . substr($output, 0, 200));
            return null;
        }

        return $output;
    }

    /**
     * Use the Node/Playwright helper script to get ad URLs from the rendered page.
     *
     * @return array<int, string>
     */
    private function scrapePageWithHeadless(int $limit): array
    {
        $scriptPath = base_path('scripts/autoscout24-headless.js');

        if (! file_exists($scriptPath)) {

            return [];
        }

        $searchUrl = $this->searchUrl;

        // Separate stderr from stdout - write stderr to a temp file and stdout to another
        $stderrFile = sys_get_temp_dir() . '/autoscout24-stderr-' . uniqid() . '.log';
        $stdoutFile = sys_get_temp_dir() . '/autoscout24-stdout-' . uniqid() . '.log';

        $command = sprintf(
            'node %s %s %d > %s 2> %s',
            escapeshellarg($scriptPath),
            escapeshellarg($searchUrl),
            $limit,
            escapeshellarg($stdoutFile),
            escapeshellarg($stderrFile)
        );

        shell_exec($command);

        // Read stderr for debugging/logging
        if (file_exists($stderrFile)) {
            $stderr = file_get_contents($stderrFile);
            if (! empty(trim($stderr))) {
                Log::info("Autoscout24 pagination debug:\n" . $stderr);
                // Also output to console if in command context
                if (app()->runningInConsole()) {
                    echo "\n=== Pagination Debug ===\n" . $stderr . "\n=======================\n";
                }
            }
            @unlink($stderrFile);
        }

        // Read stdout for JSON data
        if (! file_exists($stdoutFile)) {
            Log::warning('Autoscout24 headless script did not produce output');
            return [];
        }

        $output = file_get_contents($stdoutFile);
        @unlink($stdoutFile);

        if (empty(trim($output))) {
            Log::warning('Autoscout24 headless script returned empty output');
            return [];
        }

        // Try to extract JSON from output (in case stderr mixed in)
        // Find the JSON array in the output
        $jsonStart = strpos($output, '[');
        $jsonEnd = strrpos($output, ']');
        
        if ($jsonStart !== false && $jsonEnd !== false && $jsonEnd > $jsonStart) {
            $jsonString = substr($output, $jsonStart, $jsonEnd - $jsonStart + 1);
            $decoded = json_decode($jsonString, true);
        } else {
            $decoded = json_decode($output, true);
        }

        if (! is_array($decoded)) {
            Log::warning('Autoscout24 headless script output is not valid JSON: ' . substr($output, 0, 200));
            return [];
        }

        $urls = array_values(array_unique(array_filter($decoded, 'is_string')));

        return $urls;
    }

    /**
     * Extract ad URLs from search results HTML (DOM + regex fallback).
     *
     * @return array<int, string>
     */
    private function extractAdUrls(string $html, int $limit): array
    {

        $urls = [];

        // First try DOM with a few CSS/XPath patterns.
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        $selectors = [
            '//a[contains(@href, "/annunci/")]',
            '//a[@data-testid="ad-link"]',
            '//a[contains(@class, "ad-link")]',
        ];

        foreach ($selectors as $selector) {
            $links = $xpath->query($selector);

            if ($links === false) {
                continue;
            }

            foreach ($links as $link) {
                if (! $link instanceof \DOMElement) {
                    continue;
                }

                $href = trim($link->getAttribute('href') ?? '');

                if ($href === '' || ! $this->isValidAdUrl($href)) {
                    continue;
                }

                $fullUrl = $this->buildFullUrl($href);

                $urls[$fullUrl] = $fullUrl;

                if (count($urls) >= $limit) {
                    break 2;
                }
            }
        }

        // Fallback: regex on raw HTML if DOM selectors found nothing.
        if (empty($urls)) {

            // 1) Classic href attributes that already contain /annunci/.
            preg_match_all('/href="([^"]*\/annunci\/[^"]*)"/', $html, $matchesHref);

            foreach ($matchesHref[1] ?? [] as $href) {
                if (! $this->isValidAdUrl($href)) {
                    continue;
                }

                $fullUrl = $this->buildFullUrl($href);
                $urls[$fullUrl] = $fullUrl;

                if (count($urls) >= $limit) {
                    break;
                }
            }

            // 2) Absolute ad URLs inside inline JSON / scripts.
            if (count($urls) < $limit) {
                preg_match_all('#https://www\.autoscout24\.it/annunci/[^"\'<\s]+#', $html, $matchesAbs);

                foreach ($matchesAbs[0] ?? [] as $absUrl) {
                    if (! $this->isValidAdUrl($absUrl)) {
                        continue;
                    }

                    $urls[$absUrl] = $absUrl;

                    if (count($urls) >= $limit) {
                        break;
                    }
                }
            }

            // 3) Relative ad URLs inside JSON strings, e.g. "\/annunci\/honda-..."
            if (count($urls) < $limit) {
                preg_match_all('#"/annunci/([^"]+)"#', $html, $matchesRel);

                foreach ($matchesRel[1] ?? [] as $path) {
                    $href = '/annunci/' . ltrim($path, '/');

                    if (! $this->isValidAdUrl($href)) {
                        continue;
                    }

                    $fullUrl = $this->buildFullUrl($href);
                    $urls[$fullUrl] = $fullUrl;

                    if (count($urls) >= $limit) {
                        break;
                    }
                }
            }
        }

        $final = array_values($urls);


        return $final;
    }

    /**
     * Check if URL is a valid ad URL (not login, help, etc.).
     */
    private function isValidAdUrl(string $url): bool
    {

        $skipPatterns = [
            '/search',
            '/filter',
            '/sort',
            '/page',
            '/login',
            '/register',
            '/help',
            '/contact',
            '/about',
            '/privacy',
            '/terms',
            '/imprint',
            '/cookie',
        ];

        foreach ($skipPatterns as $pattern) {
            if (str_contains($url, $pattern)) {
                return false;
            }
        }

        $isValid = str_contains($url, '/annunci/');


        return $isValid;
    }

    /**
     * Build full URL from relative HREF.
     */
    private function buildFullUrl(string $url): string
    {

        $url = trim($url);

        if ($url === '') {
            return $this->baseUrl;
        }

        if (str_starts_with($url, 'http')) {
            $full = $url;
        } elseif (str_starts_with($url, '//')) {
            $full = 'https:' . $url;
        } elseif (str_starts_with($url, '/')) {
            $full = $this->baseUrl . $url;
        } else {
            $full = $this->baseUrl . '/' . $url;
        }


        return $full;
    }

    /**
     * Build full image URL (handles protocol-relative and relative paths).
     */
    private function buildFullImageUrl(string $src): string
    {

        $src = trim($src);

        if ($src === '') {
            return $src;
        }

        if (str_starts_with($src, 'http')) {
            $full = $src;
        } elseif (str_starts_with($src, '//')) {
            $full = 'https:' . $src;
        } elseif (str_starts_with($src, '/')) {
            $full = $this->baseUrl . $src;
        } else {
            $full = $this->baseUrl . '/' . $src;
        }


        return $full;
    }
}
