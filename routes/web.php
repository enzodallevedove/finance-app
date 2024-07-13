<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Transaction\TransferController;
use App\Http\Controllers\PaymentOptionController;

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
    // return view('pages.list_pages');
    return view('welcome');
});

Route::get('/dashboard',[DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('paymentoptions', PaymentOptionController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('bills', BillController::class);
    Route::post('bills/markaspaid/{id}', [BillController::class, 'markAsPaid'])->name('bills.markaspaid');
    Route::get('transactions/transfer/create', [TransferController::class, 'create'])->name('transactions.transfer.create');
    Route::post('transactions/transfer/store', [TransferController::class, 'store'])->name('transactions.transfer.store');
});

require __DIR__.'/auth.php';
