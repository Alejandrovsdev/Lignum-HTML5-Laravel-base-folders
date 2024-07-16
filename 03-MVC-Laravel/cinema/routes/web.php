<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Models\Movie;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('user')->group(function () {
    Route::get('/', [MovieController::class, 'showUserMoviesAndActors'])->name('user-movies-index');
    Route::post('/add-to-favorites/{movie}', [MovieController::class, 'addMovieToFavorite']);
    Route::post('/remove-from-favorites/{movie}', [MovieController::class, 'removeMovieFromFavorite']);
    Route::get('/show-favorites-movies', [MovieController::class, 'showFavoritesMovies']);
});

Route::prefix('admin')->group(function () {
    Route::get('/', [MovieController::class, 'showDashboardActorsAndMovies'])->name('admin-dashboard');

    Route::prefix('actors')->group(function () {
        Route::get('/', [ActorController::class, 'showAdminActors'])->name('admin-actors-index');
        Route::get('/create', [ActorController::class, 'showCreateActorForm'])->name('admin-actors-create');
        Route::post('/create/submit', [ActorController::class, 'createActor'])->name('admin-actors-submit');
        Route::get('/edit/{actor}', [ActorController::class, 'showEditActorForm'])->name('admin-actors-edit');
        Route::put('/update/{actor}', [ActorController::class, 'updateActor'])->name('admin-actors-update');
        Route::delete('/delete/{actor}', [ActorController::class, 'destroyActor'])->name('admin-actors-delete');
    });

    Route::prefix('movies')->group(function () {
        Route::get('/', [MovieController::class, 'showAdminMoviesAndActors'])->name('admin-movies-index');
        Route::get('/create', [MovieController::class, 'showCreateMovieForm'])->name('admin-movies-create');
        Route::post('/create/submit', [MovieController::class, 'CreateMovie'])->name('admin-movies-submit');
        Route::get('/edit/{movie}', [MovieController::class, 'showEditMovieForm'])->name('admin-movies-edit');
        Route::put('/update/{movie}', [MovieController::class, 'updateMovie'])->name('admin-movies-update');
        Route::get('/show/{movie}', [MovieController::class, 'showMovieDetails'])->name('admin-movies-show');
        Route::delete('/delete/{movie}', [MovieController::class, 'destroyMovie'])->name('admin-movies-delete');
    });
});
