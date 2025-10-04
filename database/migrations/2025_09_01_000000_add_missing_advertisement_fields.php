<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('advertisements', function (Blueprint $table) {
            // High Priority Fields
            $table->string('seller_type')->default('private');
            
            // Vehicle Condition
            
            $table->boolean('first_owner')->default(false);
            $table->boolean('service_history_available')->default(false);
            $table->boolean('warranty_available')->default(false);
            
            // Technical Specs
            $table->string('drive_type')->nullable(); // Chain, Belt, Shaft
            $table->decimal('tank_capacity_liters', 5, 2)->nullable();
            $table->integer('seat_height_mm')->nullable();
            $table->integer('top_speed_kmh')->nullable();
            $table->integer('torque_nm')->nullable();
            
            // Sales Features
            $table->boolean('financing_available')->default(false);
            $table->boolean('trade_in_possible')->default(false);
            $table->boolean('available_immediately')->default(true);
        });
    }

    public function down(): void {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn([
                'seller_type',
              
          
                'first_owner',
                'service_history_available',
                'warranty_available',
                'drive_type',
                'tank_capacity_liters',
                'seat_height_mm',
                'top_speed_kmh',
                'torque_nm',
                'financing_available',
                'trade_in_possible',
                'available_immediately'
            ]);
        });
    }
};
