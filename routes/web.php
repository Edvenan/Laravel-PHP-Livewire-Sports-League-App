<?php

use App\Http\Livewire\ShowCalendar;
use App\Http\Livewire\ShowGames;
use App\Http\Livewire\ShowRanking;
use App\Http\Livewire\ShowTeams;
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

// Home route (before login & after login)
/* Route::get('/', function () {
    return view('home');
})->name('home'); */

// Home route (before login & after login)
Route::get('/', ShowRanking::class)->name('home');
Route::get('/calendar', ShowCalendar::class)->name('calendar');

// routes accessible only after successful login via components acting as controllers
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/teams', ShowTeams::class)->name('teams');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->get('/games', ShowGames::class)->name('games');

/* Route::resource('teams', TeamController::class)->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']); */
/* Route::resource('games', GameController::class)->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']); */
