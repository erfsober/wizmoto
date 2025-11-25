<?php

namespace App\Console\Commands;

use App\Services\Autoscout24ScraperService;
use Illuminate\Console\Command;

class ImportAutoscout24WithRealImages extends Command
{
    protected $signature = 'import:autoscout24-images {--limit=1 : Number of ads to scrape}';
    protected $description = 'Scrape ads from Autoscout24 listing page and show basic data in the console';

    public function __construct(
        private readonly Autoscout24ScraperService $scraper,
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $limit = (int) $this->option('limit');

        $this->info('Starting Autoscout24 scraping…');
        $this->info("Limit: {$limit} ad(s)");

        try {
            // Get up to $limit ad URLs from the listings page (via headless scraper).
            $urls = $this->scraper->scrapePage($limit);

            if (empty($urls)) {
                $this->warn('No listings found on the listings page.');

                return;
            }

            $this->info('Scraping single ads…');

            $count = 0;

            foreach ($urls as $url) {
                $ad = $this->scraper->scrapeAd($url);

                if ($ad === null) {
                    $this->warn("Failed to scrape ad at URL: {$url}");

                    continue;
                }

                $count++;

                $this->line('');
                $this->line("Ad #{$count}");
                $this->line('  Title: ' . ($ad['title'] ?? 'N/A'));
                $this->line('  Price: ' . ($ad['price'] ?? 'N/A'));
                $this->line('  URL:   ' . $ad['url']);

                if (! empty($ad['images'])) {
                    $this->line('  First image: ' . $ad['images'][0]);
                }
            }

            $this->info('');
            $this->info("Finished. Scraped {$count} ad(s).");
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
