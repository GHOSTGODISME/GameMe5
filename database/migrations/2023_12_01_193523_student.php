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
        Schema::create('student', function (Blueprint $table) {
            $table->id(); // This will create an auto-incremented, primary key 'id' column
            $table->unsignedBigInteger('iduser');
            $table->foreign('iduser')->references('id')->on('users')->onDelete('cascade'); // This adds the foreign key constraint
           
        });
    }

    public function down()
    {
        Schema::dropIfExists('student');
    }
};
