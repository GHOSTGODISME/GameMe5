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
        Schema::create('classroom', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('coursecode');
            $table->integer('group');
            $table->string('joincode');
            $table->unsignedBigInteger('author');
            $table->foreign('author')->references('id')->on('lecturer')->onDelete('cascade');
        
        });
    }

    public function down()
    {
        Schema::dropIfExists('classroom');
    }
};
