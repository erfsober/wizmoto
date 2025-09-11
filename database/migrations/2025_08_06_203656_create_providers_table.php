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
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('address')->nullable();
            $table->string('password')->nullable();
            $table->string('village')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('show_info_in_advertisement')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->string('google_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->string('oauth_provider')->nullable();
            $table->timestamps();
        });
    }

    public function down (): void {
        Schema::dropIfExists('providers');
    }
};
