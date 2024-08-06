<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::prefix('/admin')->group(function () {
    Route::view('/', 'admin.dashboard-content')->name('admin-dashboard');
    Route::view('/actors', 'admin.actors-content')->name('admin-list-actors');
    Route::prefix('/movies')->group(function () {
        Route::view('/', 'admin.movies-content')->name('admin-list-movies');
        Route::get('/edit/{movieId}', [MovieController::class, 'getMovie']);
        Route::put('/{movieId}', [MovieController::class, 'updateMovie']);
    });
});
