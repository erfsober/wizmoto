<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up (): void {
        Schema::create('blog_posts' , function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('blog_category_id')->nullable();
            $table->text('title')->nullable();
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->integer('views')->default(0);
            $table->boolean('published')->default(false);
            $table->string('slug')->index();
            $table->string('author_name')->index();
            $table->timestamps();
        });
    }

    public function down (): void {
        Schema::dropIfExists('blog_posts');
    }
};
