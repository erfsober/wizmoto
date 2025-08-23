<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up (): void {
        Schema::create('advertisement_equipment' , function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger('advertisement_id')
                  ->nullable()
                  ->index();
            $table->unsignedBigInteger('equipment_id')
                  ->nullable()
                  ->index();
            $table->timestamps();
        });
    }

    public function down (): void {
        Schema::dropIfExists('advertisement_equipment');
    }
};
