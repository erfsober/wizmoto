<?php

namespace App\Console\Commands;

use App\Services\Autoscout24ScraperService;
use Illuminate\Console\Command;

class TestAutoscout24Scraper extends Command
{
    protected $signature = 'test:autoscout24-scraper {--limit=2 : Number of ads to scrape}';
    protected $description = 'Test the Autoscout24 scraper service';

    public function handle()
    {
        $limit = (int) $this->option('limit');
        
        $this->info("Testing Autoscout24 scraper service...");
        $this->info("Limit: {$limit} ads");
        
        try {
            $scraperService = app(Autoscout24ScraperService::class);
            
            // Test scraping
            $ads = $scraperService->scrapeMotoBikes($limit);
            
            if (empty($ads)) {
                $this->warn('No ads found or scraped from Autoscout24');
                return;
            }
            
            $this->info("Successfully scraped " . count($ads) . " ads:");
            
            foreach ($ads as $index => $ad) {
                $this->line("Ad #" . ($index + 1) . ":");
                $this->line("  Title: " . ($ad['title'] ?? 'N/A'));
                $this->line("  Price: €" . ($ad['final_price'] ?? 'N/A'));
                $this->line("  Year: " . ($ad['registration_year'] ?? 'N/A'));
                $this->line("  Mileage: " . ($ad['mileage'] ?? 'N/A') . " km");
                $this->line("  City: " . ($ad['city'] ?? 'N/A'));
                $this->line("  Brand: " . ($ad['brand'] ?? 'N/A'));
                $this->line("  Model: " . ($ad['model'] ?? 'N/A'));
                
                // Vehicle Specifications
                $this->line("  Engine Power: " . ($ad['motor_power_kw'] ?? 'N/A') . " kW (" . ($ad['motor_power_cv'] ?? 'N/A') . " CV)");
                $this->line("  Displacement: " . ($ad['motor_displacement'] ?? 'N/A') . " cc");
                $this->line("  Cylinders: " . ($ad['motor_cylinders'] ?? 'N/A'));
                $this->line("  Fuel Type: " . ($ad['fuel_type'] ?? 'N/A'));
                $this->line("  Transmission: " . ($ad['motor_change'] ?? 'N/A'));
                $this->line("  Seat Height: " . ($ad['seat_height_mm'] ?? 'N/A') . " mm");
                $this->line("  Tank Capacity: " . ($ad['tank_capacity_liters'] ?? 'N/A') . " L");
                $this->line("  Weight: " . ($ad['motor_empty_weight'] ?? 'N/A') . " kg");
                $this->line("  Top Speed: " . ($ad['top_speed_kmh'] ?? 'N/A') . " km/h");
                $this->line("  Torque: " . ($ad['torque_nm'] ?? 'N/A') . " Nm");
                
                // Provider Information
                $this->line("  Dealer: " . ($ad['dealer_name'] ?? 'N/A'));
                $this->line("  Dealer Location: " . ($ad['dealer_location'] ?? 'N/A'));
                $this->line("  Dealer Rating: " . ($ad['dealer_rating'] ?? 'N/A') . "/5");
                $this->line("  Dealer Phone: " . ($ad['dealer_phone'] ?? 'N/A'));
                
                // Additional Details
                $this->line("  Previous Owners: " . ($ad['previous_owners'] ?? 'N/A'));
                $this->line("  Service History: " . (($ad['service_history_available'] ?? false) ? 'Yes' : 'No'));
                $this->line("  Warranty: " . (($ad['warranty_available'] ?? false) ? 'Yes' : 'No'));
                $this->line("  Financing: " . (($ad['financing_available'] ?? false) ? 'Yes' : 'No'));
                
                // Images
                $imageCount = count($ad['gallery_images'] ?? []);
                $this->line("  Gallery Images: " . $imageCount . " images");
                if (!empty($ad['main_image'])) {
                    $this->line("  Main Image: " . $ad['main_image']);
                }
                
                // Description
                if (!empty($ad['description'])) {
                    $description = substr($ad['description'], 0, 100);
                    $this->line("  Description: " . $description . (strlen($ad['description']) > 100 ? '...' : ''));
                }
                
                $this->line("  URL: " . $ad['source_url']);
                $this->line("  Scraped At: " . ($ad['scraped_at'] ?? 'N/A'));
                $this->newLine();
            }
            
            // Show scraper stats
            $stats = $scraperService->getScrapingStats();
            $this->info("Scraper Statistics:");
            $this->line("  Base URL: " . $stats['base_url']);
            $this->line("  Search URL: " . $stats['search_url']);
            $this->line("  Last Scrape: " . $stats['last_scrape']);
            
        } catch (\Exception $e) {
            $this->error("Error testing scraper: " . $e->getMessage());
        }
    }
}
