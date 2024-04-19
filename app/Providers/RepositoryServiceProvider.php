<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\BillRepositoryInterface;
use App\Repositories\BillRepository;
use App\Interfaces\PaymentOptionRepositoryInterface;
use App\Repositories\PaymentOptionRepository;
use App\Interfaces\TransactionRepositoryInterface;
use App\Repositories\TransactionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            BillRepositoryInterface::class,
            BillRepository::class
        );
        $this->app->bind(
            PaymentOptionRepositoryInterface::class,
            PaymentOptionRepository::class
        );
        $this->app->bind(
            TransactionRepositoryInterface::class,
            TransactionRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
