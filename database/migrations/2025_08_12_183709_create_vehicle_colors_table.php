<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up (): void {
        Schema::create('vehicle_colors' , function ( Blueprint $table ) {
            $table->id();
            $table->string('name')
                  ->nullable();      // "Red", "Silver", etc.
            $table->string('hex_code')
                  ->nullable();  // "#FF0000" for red, "#C0C0C0" for silver
            $table->timestamps();
        });
    }

    public function down (): void {
        Schema::dropIfExists('vehicle_colors');
    }
};
