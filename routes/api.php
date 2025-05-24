<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaderboardController;

Route::get('/scores/leaderboard', [LeaderboardController::class, 'apiScores']);


