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
        Schema::create('interactive_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->bigInteger('code');
            $table->json('messages')->nullable();
            $table->string('status')->default("live");
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable()->default(null);
            $table->timestamps();

            $table->unsignedBigInteger('lecture_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interactive_sessions');
    }
};
