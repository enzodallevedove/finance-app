<?php

use App\Http\Controllers\Api\PaymentOptionController;
use App\Http\Controllers\Api\TransactionController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(PaymentOptionController::class)->group(function () {
    Route::get('/paymentoptions', 'index');
    Route::get('/paymentoption/{id}', 'show');
    Route::post('/paymentoption', 'store');
    Route::put('/paymentoption/{id}', 'update');
    Route::delete('/paymentoption/{id}', 'destroy');
});

Route::controller(TransactionController::class)->group(function () {
    Route::get('/transactions', 'index');
    Route::get('/transaction/{id}', 'show');
    Route::post('/transaction', 'store');
    Route::put('/transaction/{id}', 'update');
    Route::delete('/transaction/{id}', 'destroy');
});