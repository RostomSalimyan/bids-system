<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::post('/bid/create', [BidController::class, 'create'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum', 'admin')->prefix('bid')->group(function () {
    Route::get('/', [BidController::class, 'bids']);
    Route::post('/reply/{id}', [BidController::class, 'reply']);
    Route::get('/date', [BidController::class, 'getByDate']);
    Route::get('/active', [BidController::class, 'getActive']);

    Route::get('/completed', [BidController::class, 'getResolved']);
    Route::put('/resolved/{id}', [BidController::class, 'resolvedBid']);
});


