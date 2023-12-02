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
        Schema::create('ann_qna_answer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quesid');
            $table->foreign('quesid')->references('id')->on('ann_qna')->onDelete('cascade');
            $table->string('content', 999);
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ann_qna_answer');
    }
};
