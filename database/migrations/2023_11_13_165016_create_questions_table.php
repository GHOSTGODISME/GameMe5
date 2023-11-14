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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title')->default('');
            $table->string('type')->default('');
            $table->json('options')->nullable();
            $table->json('correct_ans');
            $table->text('answer_explanation')->nullable();
            $table->boolean('single_ans_flag')->nullable();
            $table->integer('points')->default(0);
            $table->integer('duration')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};