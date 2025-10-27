<?php

namespace App\Console\Commands;

use App\Models\Conversation;
use App\Models\Provider;
use Illuminate\Console\Command;

class CleanupOldProviderConversationsCommand extends Command
{
    protected $signature = 'cleanup:provider-conversations';
    protected $description = 'Remove conversations and messages of providers that are over one month old';

    public function handle()
    {
        $cutoffDate = now()->subMonth();
        $supportProviderId = Provider::where('username', 'wizmoto-support')->value('id');

        $query = Conversation::where('updated_at', '<', $cutoffDate);
        
        if ($supportProviderId) {
            $query->where('provider_id', '!=', $supportProviderId);
        }

        $deleted = $query->with('messages')->get();
    
        $deleted->each(function ($conversation) {
            $conversation->messages()->delete();
            $conversation->delete();
        });

        return Command::SUCCESS;
    }
}
