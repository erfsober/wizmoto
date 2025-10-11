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
        // Add seller_type to providers table
        Schema::table('providers', function (Blueprint $table) {
            $table->string('seller_type')->default('private')->after('email');
        });
        
  
        // Remove seller_type from advertisements table
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn('seller_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add seller_type back to advertisements table
        Schema::table('advertisements', function (Blueprint $table) {
            $table->string('seller_type')->nullable()->after('provider_id');
        });
        

        
        // Remove seller_type from providers table
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('seller_type');
        });
    }
};
