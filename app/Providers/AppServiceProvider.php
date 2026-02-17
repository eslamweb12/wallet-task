<?php

namespace App\Providers;

use App\Models\Product;
use App\Services\Builders\ProductBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Interfaces\Product::class, ProductBuilder::class);    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
