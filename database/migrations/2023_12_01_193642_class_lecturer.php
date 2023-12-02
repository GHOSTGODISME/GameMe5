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
        Schema::create('class_lecturer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idclass');
            $table->unsignedBigInteger('idlecturer');
            $table->foreign('idclass')->references('id')->on('classroom')->onDelete('cascade');
            $table->foreign('idlecturer')->references('id')->on('lecturer')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('class_lecturer');
    }
};
