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
            $table->text('title_it')->nullable();
            $table->text('summary_it')->nullable();
            $table->longText('body_it')->nullable();
        });
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
