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
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('type');
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('options')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('prefilled_value')->nullable();
            $table->string('scale_min_label')->nullable();
            $table->string('scale_max_label')->nullable();
            $table->string('scale_min_value')->nullable();
            $table->string('scale_max_value')->nullable();
            // $table->string('properties');
            $table->string('index');

            $table->foreignId('survey_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
