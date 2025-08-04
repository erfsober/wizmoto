<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('advertisement_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        // scooter, motorbike, bicycle, monopattino, e-bike
        DB::table('advertisement_types')->insert([
            ['title' => 'Scooter'],
            ['title' => 'Motorbike'],
            ['title' => 'Bicycle'],
            ['title' => 'E.Bike'],
            ['title' => 'Monopattino'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisement_types');
    }
};
