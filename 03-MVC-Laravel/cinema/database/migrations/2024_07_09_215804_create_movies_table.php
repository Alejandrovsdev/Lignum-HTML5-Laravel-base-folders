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
            $table->bigIncrements("movie_id");
            $table->integer('year');
            $table->string('title');
            $table->integer('duration');
            $table->text('synopsis');
            $table->string('image')->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->unsignedBigInteger('actor_principal_id');
            $table->foreign('principal_actor_id')->references('actor_id')->on('actors')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
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
