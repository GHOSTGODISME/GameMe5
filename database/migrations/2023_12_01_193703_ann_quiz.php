<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ann_quiz', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ann_id');
            $table->foreign('ann_id')->references('id')->on('announcement')->onDelete('cascade');
            $table->unsignedBigInteger('session_id');
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
        
        });
    }

    public function down()
    {
        Schema::dropIfExists('ann_quiz');
    }
};
