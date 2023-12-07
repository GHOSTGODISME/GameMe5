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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable()->default(null);
            $table->string('status')->default('active');
            $table->timestamps();

            $table->unsignedBigInteger('lecture_id')->required();
            $table->foreign('lecture_id')->references('id')->on('lecturer')->onDelete('cascade');

            // $table->foreign('lecture_id')->constrainted()->references('id')->on('lecturees')->onDelete('cascade');
            $table->unsignedBigInteger('quiz_id')->required(); 
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
