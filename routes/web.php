<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('teams.index');
});

Route::resource('teams', TeamController::class);
Route::resource('players', PlayerController::class);
Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
Route::get('/tournaments/generate', [TournamentController::class, 'generate'])->name('tournaments.generate');

