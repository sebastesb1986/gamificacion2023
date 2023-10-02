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
        Schema::create('answer', function (Blueprint $table) {
            $table->id();
            
            // Relationship with question
            $table->bigInteger('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('question');

            // Relationship with content
            $table->bigInteger('content_id')->unsigned();
            $table->foreign('content_id')->references('id')->on('content');

            // Relationship with users
            $table->bigInteger('gamer_id')->unsigned();
            $table->foreign('gamer_id')->references('id')->on('gamers');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer');
    }
};
