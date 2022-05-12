<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('movies.index');
});

Route::get(
    '/movies/toplist',
    [MovieController::class, 'toplist']
)->name('movies.toplist');

Route::post(
    '/movies/{movie}/restore',
    [MovieController::class, 'restore']
)->name('movies.restore');

Route::delete(
    '/movies/{movie}/deleteRatings',
    [MovieController::class, 'deleteRatings']
)->name('movies.deleteRatings');

Route::resource('movies', MovieController::class);
Route::resource('ratings', RatingController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
