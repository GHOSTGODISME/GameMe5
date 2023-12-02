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
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Columns to capture survey responses
            // $table->foreignId('survey_id')->constrained()->onDelet('cascade'); // Foreign key to link to surveys table
            // $table->foreignId('user_id')->nullable()->constrained(); // If capturing user information
        
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('survey_id')->references('id')->on('surveys')->onDelete('cascade');
            // $table->foreignId('survey_response_id')->references('id')->on('survey_responses')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
