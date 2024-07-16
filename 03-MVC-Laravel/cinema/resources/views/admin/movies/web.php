<?php

use App\Http\Controllers\MovieController;
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
    Route::get('actors', [ActorController::class, 'index']);
    Route::post('actors/create', [ActorController::class, 'submit']);
    Route::put('actors/update/{actorId}', [ActorController::class, 'update']);
    Route::delete('actors/delete/{actor}', [ActorController::class, 'delete']);

    Route::get('movies', [MovieController::class, 'index']);
    Route::post('movies/create', [MovieController::class, 'submit']);
    Route::put('movies/update/{movieId}', [MovieController::class, 'update']);
    Route::delete('movies/delete/{movie}', [MovieController::class, 'delete']);
});
