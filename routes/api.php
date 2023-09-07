<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\PaymentOptionController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
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