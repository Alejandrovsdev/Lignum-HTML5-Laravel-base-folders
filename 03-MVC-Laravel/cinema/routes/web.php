<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Models\Movie;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin-dashboard');

    Route::get('actors', [ActorController::class, 'index'])->name('admin-actors-index');
    Route::get('actors/create', [ActorController::class, 'create'])->name('admin-actors-create');
    Route::post('actors/create/submit', [ActorController::class, 'submit'])->name('admin-actors-submit');;
    Route::get('actors/edit/{actor}', [ActorController::class, 'edit'])->name('admin-actors-edit');
    Route::put('actors/update/{actor}', [ActorController::class, 'update'])->name('admin-actors-update');
    Route::delete('actors/delete/{actor}', [ActorController::class, 'destroy'])->name('admin-actors-delete');

    Route::get('movies', [MovieController::class, 'index'])->name('admin-movies-index');
    Route::get('movies/create', [MovieController::class, 'create'])->name('admin-movies-create');
    Route::post('movies/create/submit', [MovieController::class, 'submit'])->name('admin-movies-submit');
    Route::get('movies/edit/{movie}', [MovieController::class, 'edit'])->name('admin-movies-edit');
    Route::put('movies/update/{movie}', [MovieController::class, 'update'])->name('admin-movies-update');
    Route::get('movies/show/{movie}', [MovieController::class, 'show'])->name('admin-movies-show');
    Route::delete('movies/delete/{movie}', [MovieController::class, 'destroy'])->name('admin-movies-delete');
});
