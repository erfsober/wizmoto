<?php

namespace App\Console\Commands;

use App\Models\Message;
use App\Models\Provider;
use Illuminate\Console\Command;

class CleanupOldSupportConversationsCommand extends Command
{
    protected $signature = 'cleanup:support-messages';
    protected $description = 'Remove support conversation messages that are over 1 week old';

    public function handle()
    {
        $supportProviderId = Provider::where('username', 'wizmoto-support')->value('id');

        if (!$supportProviderId) {
            $this->warn('Support provider not found.');
            return Command::SUCCESS;
        }

        $cutoffDate = now()->subWeek();
        $messagesCount = Message::whereHas('conversation', fn($q) => $q->where('provider_id', $supportProviderId))
            ->where('created_at', '<', $cutoffDate)
            ->delete();

        $this->info("Cleanup completed: {$messagesCount} old support messages deleted.");
        
        return Command::SUCCESS;
    }
}
