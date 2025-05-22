<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/agents', [AgentController::class, 'index'])->name('agents.index');
    Route::get('/maps', [MapController::class, 'index'])->name('maps.index');
    Route::get('/maps/{uuid}', [MapController::class, 'show'])->name('maps.show');
    Route::get('/aim-training', function () {
        return view('aim_training');
    })->name('aim.training');
});

// Add these routes to your routes/web.php file

Route::prefix('leaderboard')->group(function () {
    Route::get('/', [LeaderboardController::class, 'index'])->name('leaderboard.index');
    Route::post('/', [LeaderboardController::class, 'store'])->name('leaderboard.store');
});


require __DIR__.'/auth.php';