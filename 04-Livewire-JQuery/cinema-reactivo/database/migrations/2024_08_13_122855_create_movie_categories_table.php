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
        Schema::create('movie_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('MovieID');
            $table->unsignedBigInteger('CategoryID');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('MovieID')->references('MovieID')->on('movies');
            $table->foreign('CategoryID')->references('CategoryID')->on('categories');

            $table->primary(['MovieID', 'CategoryID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_categories');
    }
};
