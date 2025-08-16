<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up (): void {
        Schema::create('fuel_types', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->nullable();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('advertisement_type_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down (): void {
        Schema::dropIfExists('fuel_types');
    }
};
