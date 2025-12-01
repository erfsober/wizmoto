<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use Illuminate\Console\Command;

class TestImageImport extends Command
{
    protected $signature = 'test:image-import {advertisement_id : The advertisement ID to test} {url : Image URL to test importing}';
    protected $description = 'Test importing a single image URL to an advertisement';

    public function handle()
    {
        $adId = (int) $this->argument('advertisement_id');
        $imageUrl = $this->argument('url');
        
        $advertisement = Advertisement::find($adId);
        
        if (!$advertisement) {
            $this->error("Advertisement #{$adId} not found!");
            return Command::FAILURE;
        }
        
        $this->info("Testing image import for Advertisement #{$adId}");
        $this->info("Image URL: {$imageUrl}");
        $this->newLine();
        
        $initialImageCount = $advertisement->getMedia('covers')->count();
        $this->info("Current images: {$initialImageCount}");
        $this->newLine();
        
        try {
            $this->info("Attempting to import image...");
            
            // Try to add the image
            $media = $advertisement
                ->addMediaFromUrl($imageUrl)
                ->toMediaCollection('covers');
            
            $this->info("✓ Image imported successfully!");
            $this->line("  Media ID: {$media->id}");
            $this->line("  File name: {$media->file_name}");
            $this->line("  Size: " . number_format($media->size / 1024, 2) . " KB");
            $this->line("  MIME type: {$media->mime_type}");
            
            $newImageCount = $advertisement->getMedia('covers')->count();
            $this->newLine();
            $this->info("Total images now: {$newImageCount}");
            
            // Show all image URLs
            $this->newLine();
            $this->info("All images for this advertisement:");
            foreach ($advertisement->getMedia('covers') as $index => $img) {
                $this->line("  " . ($index + 1) . ". {$img->getUrl()}");
            }
            
            return Command::SUCCESS;
            
        } catch (\Throwable $e) {
            $this->error("✗ Failed to import image!");
            $this->error("Error: {$e->getMessage()}");
            $this->line("Exception: " . get_class($e));
            $this->line("File: " . $e->getFile() . ":" . $e->getLine());
            
            if ($this->option('verbose')) {
                $this->line("Stack trace:");
                $this->line($e->getTraceAsString());
            }
            
            return Command::FAILURE;
        }
    }
}

