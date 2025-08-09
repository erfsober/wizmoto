<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up (): void {
        Schema::create('providers' , function ( Blueprint $table ) {
            $table->id();
            $table->string('username')->nullable()->index();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    public function down (): void {
        Schema::dropIfExists('providers');
    }
};
