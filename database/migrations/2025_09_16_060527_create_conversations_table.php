<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id')->nullable()->index();
            $table->unsignedBigInteger('guest_id')->nullable()->index();
            $table->string('raw_guest_token', 128)->nullable(); 
            $table->timestamp('token_expires_at')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('converstaions');
    }
};
