<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestImageExtraction extends Command
{
    protected $signature = 'test:image-extraction {url : The Autoscout24 ad URL to test}';
    protected $description = 'Test image extraction from an Autoscout24 ad URL';

    public function handle()
    {
        $url = $this->argument('url');
        
        $this->info("Testing image extraction for: {$url}");
        $this->newLine();
        
        $scriptPath = base_path('scripts/autoscout24-gallery.js');
        if (!file_exists($scriptPath)) {
            $this->error("Gallery script not found at: {$scriptPath}");
            return Command::FAILURE;
        }
        
        $this->info("Running gallery script...");
        $command = sprintf(
            'node %s %s 2>&1',
            escapeshellarg($scriptPath),
            escapeshellarg($url),
        );

        $output = shell_exec($command);
        
        if ($output === null || trim($output) === '') {
            $this->error("Script returned empty output!");
            return Command::FAILURE;
        }
        
        $decoded = json_decode(trim($output), true);
        
        if (!is_array($decoded)) {
            $this->error("Failed to parse JSON output!");
            $this->line("Raw output: " . substr($output, 0, 500));
            return Command::FAILURE;
        }
        
        $imageCount = count($decoded);
        
        $this->info("✓ Script executed successfully!");
        $this->newLine();
        $this->info("Found {$imageCount} image(s):");
        $this->newLine();
        
        if ($imageCount === 0) {
            $this->warn("No images found. This could mean:");
            $this->line("  - The gallery script couldn't find images on the page");
            $this->line("  - The page structure has changed");
            $this->line("  - The images are loaded via JavaScript that didn't execute");
            return Command::SUCCESS;
        }
        
        // Show first 10 images
        $displayCount = min($imageCount, 10);
        for ($i = 0; $i < $displayCount; $i++) {
            $this->line("  " . ($i + 1) . ". " . $decoded[$i]);
        }
        
        if ($imageCount > 10) {
            $this->line("  ... and " . ($imageCount - 10) . " more");
        }
        
        $this->newLine();
        $this->info("Summary:");
        $this->line("  Total images found: {$imageCount}");
        $this->line("  Images that would be imported: " . min($imageCount, 5));
        
        if ($imageCount > 5) {
            $this->warn("  Note: Only the first 5 images would be imported.");
        }
        
        return Command::SUCCESS;
    }
}

