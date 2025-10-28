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
        Schema::table('equipment', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->string('name_it')->nullable()->after('name_en');
        });
        
        // Copy existing data to English column
        DB::statement('UPDATE equipment SET name_en = name');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'name_it']);
        });
    }
};
