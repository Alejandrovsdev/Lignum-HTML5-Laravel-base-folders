<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('actors', [ActorController::class, 'index'])->name('admin-actors-index');
    Route::get('actors/create', [ActorController::class, 'create'])->name('admin-actors-create');
    Route::post('actors/create/submit', [ActorController::class, 'submit']);
    Route::get('actors/show/{actor}', [ActorController::class, 'show'])->name('admin-actors-show');
    Route::get("actors/edit/{actor}", [ActorController::class, "edit"])->name("admin-actors-edit");
    Route::put('actors/update/{actorId}', [ActorController::class, 'update']);
    Route::delete('actors/delete/{actor}', [ActorController::class, 'destroy'])->name('admin-actors-delete');

    Route::get('movies', [MovieController::class, 'index'])->name('admin-movies-index');
    Route::get('movies/create', [MovieController::class, 'create'])->name('admin-movies-create');
    Route::post('movies/create/submit', [MovieController::class, 'submit']);
    Route::put('movies/update/{movieId}', [MovieController::class, 'update']);
    Route::delete('movies/delete/{movie}', [MovieController::class, 'destroy'])->name('admin-movies-delete');
});
