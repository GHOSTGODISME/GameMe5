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
        Schema::create('ann_survey', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ann_id');
            $table->foreign('ann_id')->references('id')->on('announcement')->onDelete('cascade');
            $table->unsignedBigInteger('survey_id');
            $table->foreign('survey_id')->references('id')->on('surveys');
           
        });
    }

    public function down()
    {
        Schema::dropIfExists('ann_survey');
    }
};
