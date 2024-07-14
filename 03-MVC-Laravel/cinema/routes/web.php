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
    Route::get('/', [MovieController::class, 'userIndex'])->name('user-movies-index');
    Route::post('/add-to-favorites/{movie}', [MovieController::class, 'addMovieToFavorite']);
    Route::post('/remove-from-favorites/{movie}', [MovieController::class, 'removeMovieFromFavorite']);
    Route::get('/show-favorites-movies', [MovieController::class, 'showFavoritesMovies']);
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin-dashboard');

    Route::prefix('actors')->group(function () {
        Route::get('/', [ActorController::class, 'index'])->name('admin-actors-index');
        Route::get('/create', [ActorController::class, 'create'])->name('admin-actors-create');
        Route::post('/create/submit', [ActorController::class, 'submit'])->name('admin-actors-submit');
        Route::get('/edit/{actor}', [ActorController::class, 'edit'])->name('admin-actors-edit');
        Route::put('/update/{actor}', [ActorController::class, 'update'])->name('admin-actors-update');
        Route::delete('/delete/{actor}', [ActorController::class, 'destroy'])->name('admin-actors-delete');
    });

    Route::prefix('movies')->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('admin-movies-index');
        Route::get('/create', [MovieController::class, 'create'])->name('admin-movies-create');
        Route::post('/create/submit', [MovieController::class, 'submit'])->name('admin-movies-submit');
        Route::get('/edit/{movie}', [MovieController::class, 'edit'])->name('admin-movies-edit');
        Route::put('/update/{movie}', [MovieController::class, 'update'])->name('admin-movies-update');
        Route::get('/show/{movie}', [MovieController::class, 'show'])->name('admin-movies-show');
        Route::delete('/delete/{movie}', [MovieController::class, 'destroy'])->name('admin-movies-delete');
    });
});
