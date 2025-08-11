<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up (): void {
        Schema::create('advertisement_vehicle_data' , function ( Blueprint $table ) {
            $table->id();
            $table->string('brand')->nullable()->comment('brand of vehicle');
            $table->string('vehicle_model')->nullable();
            $table->string('version_model')->nullable()->comment('Use this free text field to specify the version of the template you have selected.');
            $table->timestamps();
        });
    }

    public function down (): void {
        Schema::dropIfExists('advertisement_vehicle_data');
    }
};
