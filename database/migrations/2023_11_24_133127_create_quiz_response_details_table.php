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
        Schema::create('quiz_response_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_response_id')->nullable();
            $table->unsignedBigInteger('question_id')->nullable();
            $table->json('user_response')->nullable();
            $table->boolean('correctness')->default(false);
            $table->integer('points')->default(0);
            $table->integer('time_usage')->nullable();
            $table->timestamps();

            $table->foreign('quiz_response_id')->references('id')->on('quiz_responses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_response_details');
    }
};
