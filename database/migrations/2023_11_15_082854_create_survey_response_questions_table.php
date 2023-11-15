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
        Schema::create('survey_response_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('survey_response_id')->constrained('survey_responses');
            $table->foreignId('survey_question_id')->constrained(); // Foreign key to link to survey_questions table
            $table->json('answers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_response_questions');
    }
};
