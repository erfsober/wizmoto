<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up (): void {
        Schema::create('blog_categories' , function ( Blueprint $table ) {
            $table->id();
            $table->string('title')->nullable();
            $table->boolean('published')->default(false);
            $table->string('slug')->nullable();
            $table->integer('sort')->nullable();
            $table->timestamps();
        });
    }

    public function down (): void {
        Schema::dropIfExists('blog_categories');
    }
};
