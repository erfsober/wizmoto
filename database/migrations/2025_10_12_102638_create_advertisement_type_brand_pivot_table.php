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
        // Create the pivot table for many-to-many relationship
        Schema::create('advertisement_type_brand', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advertisement_type_id')->nullable()->index();
            $table->unsignedBigInteger('brand_id')->nullable()->index();
            $table->timestamps();

           

            // Prevent duplicate combinations
            $table->unique(['advertisement_type_id', 'brand_id']);
        });

        // Remove the old advertisement_type_id column from brands table
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('advertisement_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the old column
        Schema::table('brands', function (Blueprint $table) {
            $table->unsignedBigInteger('advertisement_type_id')->nullable()->index();
        });

        // Drop the pivot table
        Schema::dropIfExists('advertisement_type_brand');
    }
};
