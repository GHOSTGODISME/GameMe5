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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();

            $table->string('title')->default('');
            $table->integer('type');
            $table->json('options')->nullable();
            $table->json('correct_ans')->required();
            $table->text('answer_explaination')->nullable();
            $table->boolean('single_ans_flag')->nullable();
            $table->integer('points')->default(0);
            $table->integer('duration')->default(0);
            $table->integer('index');
            $table->timestamps();

            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
