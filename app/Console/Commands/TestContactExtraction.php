<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestContactExtraction extends Command
{
    protected $signature = 'test:contact-extraction {url : The Autoscout24 ad URL to test}';
    protected $description = 'Test phone and WhatsApp extraction from an Autoscout24 ad URL';

    public function handle()
    {
        $url = $this->argument('url');
        
        $this->info("Testing contact extraction for: {$url}");
        $this->newLine();
        
        $scriptPath = base_path('scripts/autoscout24-contact.js');
        if (!file_exists($scriptPath)) {
            $this->error("Contact script not found at: {$scriptPath}");
            return 1;
        }
        
        // Use separate files for stdout and stderr
        $stdoutFile = sys_get_temp_dir() . '/test-contact-stdout-' . uniqid() . '.log';
        $stderrFile = sys_get_temp_dir() . '/test-contact-stderr-' . uniqid() . '.log';

        $command = sprintf(
            'node %s %s > %s 2> %s',
            escapeshellarg($scriptPath),
            escapeshellarg($url),
            escapeshellarg($stdoutFile),
            escapeshellarg($stderrFile)
        );

        $this->info("Running contact script...");
        shell_exec($command);
        
        // Read stderr for debugging
        $stderr = '';
        if (file_exists($stderrFile)) {
            $stderr = file_get_contents($stderrFile);
            @unlink($stderrFile);
        }
        
        // Read stdout for JSON
        if (!file_exists($stdoutFile)) {
            $this->error("Script did not produce output file!");
            return 1;
        }
        
        $output = file_get_contents($stdoutFile);
        @unlink($stdoutFile);
        
        if (empty(trim($output))) {
            $this->error("Script returned empty output!");
            if (!empty($stderr)) {
                $this->warn("Stderr: " . trim($stderr));
            }
            return 1;
        }
        
        $this->newLine();
        $this->info("=== STDOUT OUTPUT ===");
        $this->line($output);
        $this->newLine();
        
        if (!empty($stderr)) {
            $this->info("=== STDERR OUTPUT (Debug Info) ===");
            $this->line($stderr);
            $this->newLine();
        }
        
        // Parse JSON
        $decoded = json_decode(trim($output), true);
        if (!is_array($decoded)) {
            $this->error("Failed to parse JSON output!");
            return 1;
        }
        
        $phone = $decoded['phone'] ?? null;
        $whatsapp = $decoded['whatsapp'] ?? null;
        
        $this->info("=== EXTRACTED CONTACTS ===");
        if ($phone) {
            $this->info("✓ Phone: {$phone}");
        } else {
            $this->error("✗ Phone: NOT FOUND");
        }
        
        if ($whatsapp) {
            $this->info("✓ WhatsApp: {$whatsapp}");
        } else {
            $this->error("✗ WhatsApp: NOT FOUND");
        }
        
        return 0;
    }
}

