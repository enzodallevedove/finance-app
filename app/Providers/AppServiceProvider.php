<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CreateBillTransactionService;
use App\Services\UpdatePaymentOptionBalanceService;
use App\Services\CreateTransferTransactionsService;
use App\Interfaces\CreateBillTransactionServiceInterface;
use App\Interfaces\UpdatePaymentOptionBalanceServiceInterface;
use App\Interfaces\CreateTransferTransactionsServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UpdatePaymentOptionBalanceServiceInterface::class,
            UpdatePaymentOptionBalanceService::class
        );

        $this->app->bind(
            CreateBillTransactionServiceInterface::class,
            CreateBillTransactionService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
