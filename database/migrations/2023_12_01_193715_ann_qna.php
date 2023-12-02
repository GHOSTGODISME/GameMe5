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
        Schema::create('ann_qna', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ann_id');
            $table->foreign('ann_id')->references('id')->on('announcement')->onDelete('cascade');
            $table->string('question', 999);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ann_qna');
    }
};
