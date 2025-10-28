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
        Schema::table('about_us', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('title_it')->nullable()->after('title_en');
            $table->text('content_en')->nullable()->after('content');
            $table->text('content_it')->nullable()->after('content_en');
        });
        
        // Copy existing data to _en columns
        DB::statement('UPDATE about_us SET title_en = title');
        DB::statement('UPDATE about_us SET content_en = content');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            //
        });
    }
};
