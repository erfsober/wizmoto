<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fuel_types', function (Blueprint $table) {
            // Remove the advertisement_type_id column
            // Fuel types are now universal and not tied to specific advertisement types
            $table->dropColumn('advertisement_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fuel_types', function (Blueprint $table) {
            // Add it back if needed
            $table->unsignedBigInteger('advertisement_type_id')->nullable()->index();
        });
    }
};
