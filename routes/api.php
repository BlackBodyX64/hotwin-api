<?php

use App\Http\Controllers\CasinoController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameTypeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieTypeController;
use App\Http\Controllers\PromotionController;
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
Route::post('/login_admin', [LoginController::class, 'loginAdmin']);

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

//Promotion
Route::get('/view_promotion/{id}', [PromotionController::class, 'view']);
Route::get('/all_promotion', [PromotionController::class, 'all']);

//MovieType
Route::get('/view_movie_type/{id}', [MovieTypeController::class, 'view']);
Route::get('/all_movie_type', [MovieTypeController::class, 'all']);

//Movie
Route::get('/view_movie/{id}', [MovieController::class, 'view']);
Route::get('/all_movie', [MovieController::class, 'all']);

// Route::group(['middleware' => 'checkjwt'], function () {

    //Casino
    Route::post('/add_casino', [CasinoController::class, 'addCasino']);
    Route::post('/edit_casino/{id}', [CasinoController::class, 'editCasino']);
    Route::delete('/delete_casino/{id}', [CasinoController::class, 'deleteCasino']);
    Route::delete('/casino/page', [CasinoController::class, 'page']);

    //GameType
    Route::post('/add_game_type', [GameTypeController::class, 'addGameType']);
    Route::post('/edit_game_type/{id}', [GameTypeController::class, 'editGameType']);
    Route::delete('/delete_game_type/{id}', [GameTypeController::class, 'deleteGameType']);

    //Game
    Route::post('/add_game', [GameController::class, 'add']);
    Route::post('/edit_game/{id}', [GameController::class, 'edit']);
    Route::delete('/delete_game/{id}', [GameController::class, 'delete']);

    //Promotion
    Route::post('/add_promotion', [PromotionController::class, 'add']);
    Route::post('/edit_promotion/{id}', [PromotionController::class, 'edit']);
    Route::delete('/delete_promotion/{id}', [PromotionController::class, 'delete']);

    //MovieType
    Route::post('/add_movie_type', [MovieTypeController::class, 'add']);
    Route::post('/edit_movie_type/{id}', [MovieTypeController::class, 'edit']);
    Route::delete('/delete_movie_type/{id}', [MovieTypeController::class, 'delete']);

    //Movie
    Route::post('/add_movie', [MovieController::class, 'add']);
    Route::post('/edit_movie/{id}', [MovieController::class, 'edit']);
    Route::delete('/delete_movie/{id}', [MovieController::class, 'delete']);
// });
