<?php

namespace App\Console\Commands;

use App\Services\OpenAiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TranslateMissingItalianColumns extends Command
{
  
    protected $signature = 'translations:fill-italian {--dry-run : Show what would be translated without writing to the database}';

  
    protected $description = 'Translate *_en columns to *_it for all configured tables where the Italian value is empty';

   
    public function handle(OpenAiService $openAi): void
    {
        $dryRun = (bool) $this->option('dry-run');

        if ($dryRun) {
            $this->warn('Running in DRY RUN mode – no database changes will be written.');
        }

        // Tables and base column names for which we have *_en and *_it variants.
        $tables = [
            'about_us'        => ['title', 'content'],
            'faqs'            => ['question', 'answer'],
            'blog_posts'      => ['title', 'summary', 'body'],
            'blog_categories' => ['title'],
            'brands'          => ['name'],
            'fuel_types'      => ['name'],
            'equipment'       => ['name'],
            'vehicle_colors'  => ['name'],
            'vehicle_bodies'  => ['name'],
        ];

        // Configure OpenAI once.
        $openAi
            ->setSystemMessage('You are a translation engine. Translate the input text literally into Italian and return only the translated sentence.');

        foreach ($tables as $table => $columns) {
            $this->info("Processing table: {$table}");

            $query = DB::table($table);

            // Only rows where at least one *_it column is null/empty.
            $query->where(function ($q) use ($columns) {
                foreach ($columns as $column) {
                    $colIt = $column . '_it';
                    $q->orWhereNull($colIt)
                      ->orWhere($colIt, '');
                }
            });

            $rows = $query->get();

            if ($rows->isEmpty()) {
                $this->line("  No rows with empty Italian columns found.");
                continue;
            }

            $this->line('  Rows to process: ' . $rows->count());

            foreach ($rows as $row) {
                $updates = [];

                foreach ($columns as $column) {
                    $colEn = $column . '_en';
                    $colIt = $column . '_it';

                    // Source text: prefer *_en, fall back to original column if needed.
                    $source = $row->{$colEn} ?? $row->{$column} ?? null;
                    $currentIt = $row->{$colIt} ?? null;

                    if (! is_string($source) || trim($source) === '') {
                        continue;
                    }

                    if (is_string($currentIt) && trim($currentIt) !== '') {
                        // Already translated.
                        continue;
                    }

                    $preview = mb_strimwidth($source, 0, 60, '...');

                    if ($dryRun) {
                        $this->line("  [DRY RUN] {$table} #{$row->id}: {$colEn} → {$colIt} ({$preview})");
                        continue;
                    }

                    $message = "Translate this to Italian: \"{$source}\"";

                    try {
                        $translated = $openAi->generateResponseWithoutProcess($message);
                    } catch (\Throwable $e) {
                        $this->error("  Failed to translate {$table} #{$row->id} ({$colEn}): {$e->getMessage()}");
                        continue;
                    }

                    if (is_string($translated) && trim($translated) !== '') {
                        $updates[$colIt] = $translated;
                        $this->line("  Updated {$table} #{$row->id}: {$colEn} → {$colIt}");
                    }
                }

                if (! empty($updates) && ! $dryRun) {
                    DB::table($table)
                        ->where('id', $row->id)
                        ->update($updates);
                }
            }
        }

        $this->info('Translation of missing Italian columns completed.');
    }
}


