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
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('MovieID');
            $table->string('Title', 50);
            $table->integer('Duration');
            $table->text('Synopsis');
            $table->string('Image')->nullable();
            $table->boolean('IsFavorite')->default(false);
            $table->timestamps();
            $table->unsignedBigInteger('PrincipalActorID')->nullable();
            $table->softDeletes();

            $table->foreign('PrincipalActorID')->references('ActorID')->on('actors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
