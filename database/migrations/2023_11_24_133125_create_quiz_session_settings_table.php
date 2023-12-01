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
        Schema::create('quiz_session_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('show_leaderboard_flag')->default(false)->default(false); // Example default value false
            $table->boolean('shuffle_option_flag')->default(true)->default(false); // Example default value true 
           $table->timestamps();
           
            $table->unsignedBigInteger('session_id')->constrainted()->nullable(); 
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_session_settings');
    }
};
