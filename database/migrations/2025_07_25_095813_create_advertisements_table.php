<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up (): void {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id')->index();
            $table->unsignedBigInteger('advertisement_type_id')->index();
            //vehicle data
            $table->unsignedBigInteger('brand_id')->nullable()->comment('brand of vehicle');
            $table->unsignedBigInteger('vehicle_model_id')->nullable();
            $table->string('version_model')->nullable()->comment('Use this free text field to specify the version of the template you have selected.');
            //Characteristics
            $table->unsignedBigInteger('vehicle_body_id')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->boolean('is_metallic_paint')->default(false);
            //state
            $table->string('vehicle_category')->nullable();
            $table->integer('mileage')->nullable();
            $table->string('registration_month')->nullable();
            $table->string('registration_year')->nullable();
            $table->integer('previous_owners')->nullable();
            $table->boolean('coupon_documentation')->default(false);
            $table->string('next_review_year')->nullable();
            $table->string('next_review_month')->nullable();
            $table->string('last_service_month')->nullable();
            $table->string('last_service_year')->nullable();
            $table->boolean('damaged_vehicle')->default(false);
//equipment
            ///motor
            $table->string('motor_change')->nullable()->comment('Manual / Automatic');
            $table->integer('motor_power_kw')->nullable()->comment('Power in kW');
            $table->integer('motor_power_cv')->nullable()->comment('Power in HP / CV');
            $table->integer('motor_marches')->nullable()->comment('Number of gears');
            $table->integer('motor_cylinders')->nullable();
            $table->integer('motor_displacement')->nullable()->comment('Engine displacement in cc');
            $table->integer('motor_empty_weight')->nullable()->comment('Empty weight in kg');
//Environment
            $table->string('fuel_type_id')->nullable();
            $table->decimal('combined_fuel_consumption', 5, 2)->nullable();
            $table->integer('co2_emissions')->nullable();
            $table->string('emissions_class')->nullable();
            //Vehicle description
            $table->text('description')->nullable();
//price
            $table->boolean('price_negotiable')->default(false);
            $table->boolean('tax_deductible')->default(false);
            $table->string('final_price')->nullable();
            ///address
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('international_prefix', 5)->nullable(); // e.g., +49
            $table->string('prefix', 5)->nullable(); // e.g., 030
            $table->string('telephone', 20)->nullable(); // e.g., 12345678
            $table->boolean('show_phone')->nullable(); // e.g., 12345678

            $table->timestamps();
        });
    }

    public function down (): void {
        Schema::dropIfExists('advertisements');
    }
};
