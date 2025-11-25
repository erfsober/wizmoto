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
        Log::info('Autoscout24ScraperService@scrapePage called', [
            'limit' => $limit,
        ]);

        // First try using the headless Node scraper (Playwright).
        $urls = $this->scrapePageWithHeadless($limit);

        if (! empty($urls)) {
            Log::info('Autoscout24ScraperService@scrapePage finished (headless)', [
                'urls_count' => count($urls),
            ]);

            return $urls;
        }

        Log::warning('Autoscout24ScraperService@scrapePage: headless scraper returned no URLs, falling back to HTML parsing');

        // Fallback: old HTML-based extraction (will likely return 0, but keep as backup).
        $html = $this->fetchHtml($this->searchUrl);

        if ($html === null) {
            Log::warning('Autoscout24ScraperService@scrapePage: fetchHtml returned null in fallback');

            return [];
        }

        $urls = $this->extractAdUrls($html, $limit);

        Log::info('Autoscout24ScraperService@scrapePage finished (fallback HTML)', [
            'urls_count' => count($urls),
        ]);

        return $urls;
    }

    /**
     * Scrape a single ad page and return basic data.
     *
     * @return array<string, mixed>|null
     */
    public function scrapeAd(string $url): ?array
    {
        Log::info('Autoscout24ScraperService@scrapeAd called', [
            'url' => $url,
        ]);

        $html = $this->fetchHtml($url);

        if ($html === null) {
            Log::warning('Autoscout24ScraperService@scrapeAd: fetchHtml returned null', [
                'url' => $url,
            ]);
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
            'brand'        => null, // human-readable brand name, e.g. "Honda"
            'model'        => null, // human-readable model name, e.g. "XL 750 Transalp"
            'brand_code'   => null, // internal Autoscout24 brand id
            'model_code'   => null, // internal Autoscout24 model id
            'city'         => null, // e.g. "Alessandria_AL"
            'zip'          => null, // e.g. "IT15121"
            'dealer_id'    => null, // Autoscout24 dealer ID
            'seller_type'  => null, // 'dealer' or 'private'
            'fuel_code'    => null, // e.g. 'B' (Benzina), 'D' (Diesel), 'E' (Electric)
            'gear_code'    => null, // e.g. 'M' (Manual)
            'condition'    => null, // e.g. 'new', 'used'
            'power_kw'     => null, // numeric kW if available
            'power_cv'     => null, // numeric CV/HP if available
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
            }
        }

        $data = [
            'url'         => $url,
            'title'       => $title !== null ? trim($title) : null,
            'price'       => $price,
            'description' => $description !== null ? trim($description) : null,
            'images'      => array_values(array_unique(array_filter($images))),
            'meta'        => $meta,
        ];

        Log::info('Autoscout24ScraperService@scrapeAd finished', [
            'url' => $url,
            'has_title' => $data['title'] !== null,
            'has_price' => $data['price'] !== null,
            'images_count' => count($data['images']),
        ]);

        return $data;
    }

    /**
     * Low-level HTTP fetch.
     */
    private function fetchHtml(string $url): ?string
    {
        Log::debug('Autoscout24ScraperService@fetchHtml called', [
            'url' => $url,
        ]);

        try {
            $response = Http::withHeaders([
                'User-Agent' => $this->userAgent,
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            ])->get($url);

            if (! $response->successful()) {
                Log::warning('Autoscout24ScraperService@fetchHtml: non-success status', [
                    'url' => $url,
                    'status' => $response->status(),
                ]);
                return null;
            }

            Log::debug('Autoscout24ScraperService@fetchHtml: successful response', [
                'url' => $url,
            ]);

            return $response->body();
        } catch (\Throwable $e) {
            Log::error('Autoscout24ScraperService@fetchHtml exception', [
                'url' => $url,
                'message' => $e->getMessage(),
            ]);
            return null;
        }
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
            Log::error('Autoscout24ScraperService@scrapePageWithHeadless: script not found', [
                'script' => $scriptPath,
            ]);

            return [];
        }

        $searchUrl = $this->searchUrl;

        $command = sprintf(
            'node %s %s %d 2>&1',
            escapeshellarg($scriptPath),
            escapeshellarg($searchUrl),
            $limit
        );

        Log::info('Autoscout24ScraperService@scrapePageWithHeadless executing command', [
            'command' => $command,
        ]);

        $output = shell_exec($command);

        if ($output === null || trim($output) === '') {
            Log::warning('Autoscout24ScraperService@scrapePageWithHeadless: empty output from node script');

            return [];
        }

        $decoded = json_decode($output, true);

        if (! is_array($decoded)) {
            Log::error('Autoscout24ScraperService@scrapePageWithHeadless: invalid JSON from node script', [
                'output_sample' => mb_substr($output, 0, 500),
            ]);

            return [];
        }

        $urls = array_values(array_unique(array_filter($decoded, 'is_string')));

        Log::info('Autoscout24ScraperService@scrapePageWithHeadless finished', [
            'urls_count' => count($urls),
        ]);

        return $urls;
    }

    /**
     * Extract ad URLs from search results HTML (DOM + regex fallback).
     *
     * @return array<int, string>
     */
    private function extractAdUrls(string $html, int $limit): array
    {
        Log::debug('Autoscout24ScraperService@extractAdUrls called', [
            'limit' => $limit,
            'html_length' => strlen($html),
        ]);

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
            Log::debug('Autoscout24ScraperService@extractAdUrls: DOM selectors found no URLs, using regex fallback');

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

        Log::info('Autoscout24ScraperService@extractAdUrls finished', [
            'urls_count' => count($final),
        ]);

        return $final;
    }

    /**
     * Check if URL is a valid ad URL (not login, help, etc.).
     */
    private function isValidAdUrl(string $url): bool
    {
        Log::debug('Autoscout24ScraperService@isValidAdUrl called', [
            'url' => $url,
        ]);

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
                Log::debug('Autoscout24ScraperService@isValidAdUrl: url rejected by skip pattern', [
                    'url' => $url,
                    'pattern' => $pattern,
                ]);
                return false;
            }
        }

        $isValid = str_contains($url, '/annunci/');

        Log::debug('Autoscout24ScraperService@isValidAdUrl result', [
            'url' => $url,
            'is_valid' => $isValid,
        ]);

        return $isValid;
    }

    /**
     * Build full URL from relative HREF.
     */
    private function buildFullUrl(string $url): string
    {
        Log::debug('Autoscout24ScraperService@buildFullUrl called', [
            'url' => $url,
        ]);

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

        Log::debug('Autoscout24ScraperService@buildFullUrl result', [
            'original' => $url,
            'full' => $full,
        ]);

        return $full;
    }

    /**
     * Build full image URL (handles protocol-relative and relative paths).
     */
    private function buildFullImageUrl(string $src): string
    {
        Log::debug('Autoscout24ScraperService@buildFullImageUrl called', [
            'src' => $src,
        ]);

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

        Log::debug('Autoscout24ScraperService@buildFullImageUrl result', [
            'original' => $src,
            'full' => $full,
        ]);

        return $full;
    }
}