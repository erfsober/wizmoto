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
            $table->string('title')->nullable();
            $table->string('price')->nullable();
            $table->boolean('price_negotiable')->default(false);
            $table->boolean('tax_deductible')->default(false);
            $table->timestamps();
        });
    }

    public function down (): void {
        Schema::dropIfExists('advertisements');
    }
};
