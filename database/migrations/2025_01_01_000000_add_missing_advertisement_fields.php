<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('advertisements', function (Blueprint $table) {
            // High Priority Fields
            $table->enum('seller_type', ['private', 'dealer'])->default('private')->after('final_price');
            $table->string('motorcycle_category')->nullable()->after('vehicle_category');
            
            // Vehicle Condition
            $table->boolean('accident_free')->default(true)->after('damaged_vehicle');
            $table->boolean('first_owner')->default(false)->after('previous_owners');
            $table->boolean('service_history_available')->default(false)->after('first_owner');
            $table->boolean('warranty_available')->default(false)->after('service_history_available');
            
            // Technical Specs
            $table->string('drive_type')->nullable()->after('motor_displacement'); // Chain, Belt, Shaft
            $table->decimal('tank_capacity_liters', 5, 2)->nullable()->after('drive_type');
            $table->integer('seat_height_mm')->nullable()->after('tank_capacity_liters');
            $table->integer('top_speed_kmh')->nullable()->after('seat_height_mm');
            $table->integer('torque_nm')->nullable()->after('top_speed_kmh');
            
            // Sales Features
            $table->boolean('financing_available')->default(false)->after('tax_deductible');
            $table->boolean('trade_in_possible')->default(false)->after('financing_available');
            $table->boolean('available_immediately')->default(true)->after('trade_in_possible');
        });
    }

    public function down(): void {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn([
                'seller_type',
                'motorcycle_category',
                'accident_free',
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
