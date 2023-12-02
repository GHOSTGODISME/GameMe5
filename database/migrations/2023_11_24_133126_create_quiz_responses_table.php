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
        Schema::create('quiz_responses', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->float('accuracy')->nullable();
            $table->integer('correct_answer_count')->nullable();
            $table->integer('incorrect_answer_count')->nullable();
            $table->integer('total_points')->nullable();
            $table->float('average_time')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('session_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_responses');
    }
};
