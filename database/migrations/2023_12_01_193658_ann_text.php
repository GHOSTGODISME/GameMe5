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
        Schema::create('ann_text', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('annid');
            $table->foreign('annid')->references('id')->on('announcement')->onDelete('cascade');
            $table->string('content', 999);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ann_text');
    }
};
