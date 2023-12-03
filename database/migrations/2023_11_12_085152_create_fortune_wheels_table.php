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
        Schema::create('fortune_wheels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->json('entries');
            $table->json('results');
            $table->unsignedBigInteger('id_lecturer'); // Foreign key column
            $table->foreign('id_lecturer')->references('id')->on('lecturer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fortune_wheels');
    }
};
