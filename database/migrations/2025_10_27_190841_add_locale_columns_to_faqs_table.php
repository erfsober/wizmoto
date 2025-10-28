<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('question_en')->nullable()->after('question');
            $table->string('question_it')->nullable()->after('question_en');
            $table->text('answer_en')->nullable()->after('answer');
            $table->text('answer_it')->nullable()->after('answer_en');
        });
        
        // Copy existing data to _en columns
        DB::statement('UPDATE faqs SET question_en = question');
        DB::statement('UPDATE faqs SET answer_en = answer');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            //
        });
    }
};
