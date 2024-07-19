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
            $table->string('title', 50);
            $table->integer('duration');
            $table->text('synopsis');
            $table->string('image')->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->timestamps();
            $table->unsignedBigInteger('principal_actor_id')->nullable();
            $table->softDeletes();

            $table->foreign('principal_actor_id')->references('ActorID')->on('actors')->onDelete('cascade');
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
