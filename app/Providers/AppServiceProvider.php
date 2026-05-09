<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            \App\Services\PricingServiceInterface::class,
            \App\Services\BasicPricingService::class
        );
    }

    public function boot(): void
    {
        //
    }
}
