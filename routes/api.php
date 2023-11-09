<?php

use App\Http\Controllers\CasinoController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameTypeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [LoginController::class, 'login']);

Route::post('/register', [UserController::class, 'register']);

//Casino
Route::get('/view_casino/{id}', [CasinoController::class, 'viewCasino']);
Route::get('/all_casino', [CasinoController::class, 'allCasino']);

//GameType
Route::get('/view_game_type/{id}', [GameTypeController::class, 'viewGameType']);
Route::get('/all_game_type', [GameTypeController::class, 'allGameType']);

//Game
Route::get('/view_game/{id}', [GameController::class, 'view']);
Route::get('/all_game', [GameController::class, 'all']);

Route::group(['middleware' => 'checkjwt'], function () {

    //Casino
    Route::post('/add_casino', [CasinoController::class, 'addCasino']);
    Route::post('/edit_casino/{id}', [CasinoController::class, 'editCasino']);
    Route::delete('/delete_casino/{id}', [CasinoController::class, 'deleteCasino']);

    //GameType
    Route::post('/add_game_type', [GameTypeController::class, 'addGameType']);
    Route::post('/edit_game_type/{id}', [GameTypeController::class, 'editGameType']);
    Route::delete('/delete_game_type/{id}', [GameTypeController::class, 'deleteGameType']);

    //Game
    Route::post('/add_game', [GameController::class, 'add']);
    Route::post('/edit_game/{id}', [GameController::class, 'edit']);
    Route::delete('/delete_game/{id}', [GameController::class, 'delete']);
});
