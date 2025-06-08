<?php


use App\Http\Controllers\PuzzleController;
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


Route::middleware('auth')->group(function () {

    Route::get('dashboard', [PuzzleController::class, 'index'])->name('dashboard.index');
    Route::post('submit-answer', [PuzzleController::class, 'store'])->name('puzzle.store');
    Route::get('leader-board', [PuzzleController::class, 'leaderBoard'])->name('puzzle.leader');
    Route::post('end-game', [PuzzleController::class, 'endGame'])->name('puzzle.end');

});

require __DIR__ . '/auth.php';
