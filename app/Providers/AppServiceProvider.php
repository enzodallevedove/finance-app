<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UpdatePaymentOptionBalanceService;
use App\Interfaces\UpdatePaymentOptionBalanceServiceInterface;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
