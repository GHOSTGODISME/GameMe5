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
        Schema::create('ann_polls_result', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('polls_id');
            $table->foreign('polls_id')->references('id')->on('ann_polls')->onDelete('cascade');
            $table->integer('option');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
         
        });
    }

    public function down()
    {
        Schema::dropIfExists('ann_polls_result');
    }
};
