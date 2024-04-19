<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\BillRepositoryInterface;
use App\Repositories\BillRepository;

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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
