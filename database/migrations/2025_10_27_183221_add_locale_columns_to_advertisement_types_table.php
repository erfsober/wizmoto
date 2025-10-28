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
        Schema::table('advertisement_types', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('title_it')->nullable()->after('title_en');
        });
        
        // Copy existing data to English column
        DB::statement('UPDATE advertisement_types SET title_en = title');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisement_types', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'title_it']);
        });
    }
};
