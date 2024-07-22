<?php

use App\Livewire\Actors\ListActors;
use App\Livewire\Movies\ListMovies;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::prefix('admin')->group(function () {
    Route::view('/', 'dashboard')->name('admin-dashboard');

    Route::prefix('actors')->group(function () {
        Route::get('/', ListActors::class)->name('admin-list-actors');
    });

    Route::prefix('movies')->group(function () {
        Route::get('/', ListMovies::class)->name('admin-list-movies');
    });

});
