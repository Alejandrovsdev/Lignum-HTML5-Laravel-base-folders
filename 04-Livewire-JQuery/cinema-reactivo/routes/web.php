<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::prefix('/admin')->group(function () {
    Route::get('/', [MovieController::class, 'showDashboardActorsAndMovies'])->name('admin-dashboard');
    Route::view('/actors', 'admin.actors-content')->name('admin-list-actors');
    Route::prefix('/movies')->group(function () {
        Route::view('/', 'admin.movies-content')->name('admin-list-movies');
        Route::get('/edit/{movieId}', [MovieController::class, 'getMovie']);
        Route::put('/{movieId}', [MovieController::class, 'updateMovie']);
    });
});

Route::prefix('/jq-practice')->group(function () {
    Route::get('/actors', [ActorController::class, 'listActors'])->name('jq-practice-actors');
    Route::post('actors/create-actor', [ActorController::class, 'createActor']);
    Route::get('/movies', [MovieController::class, 'listMovies'])->name('jq-practice-movies');
    Route::post('/movies/create-movie', [MovieController::class, 'createMovie'])->name('createMovie');
});
