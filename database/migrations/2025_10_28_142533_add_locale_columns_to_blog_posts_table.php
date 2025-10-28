<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            // Add locale columns for title
            $table->text('title_en')->nullable()->after('title');
            $table->text('title_it')->nullable()->after('title_en');
            
            // Add locale columns for summary
            $table->text('summary_en')->nullable()->after('summary');
            $table->text('summary_it')->nullable()->after('summary_en');
            
            // Add locale columns for body
            $table->longText('body_en')->nullable()->after('body');
            $table->longText('body_it')->nullable()->after('body_en');
        });
        
        // Copy existing data to English columns
        DB::statement('UPDATE blog_posts SET title_en = title, summary_en = summary, body_en = body');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn([
                'title_en', 'title_it',
                'summary_en', 'summary_it',
                'body_en', 'body_it'
            ]);
        });
    }
};
