<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Contract\ProductRepositoryInterface',
            'App\Repositories\ProductRepository'
        );
        $this->app->bind(
            'App\Repositories\Contract\CustomerRepositoryInterface',
            'App\Repositories\CustomerRepository'
        );
        $this->app->bind(
            'App\Repositories\Contract\AddressRepositoryInterface',
            'App\Repositories\AddressRepository'
        );
        $this->app->bind(
            'App\Repositories\Contract\OrderRepositoryInterface',
            'App\Repositories\OrderRepository'
        );
        $this->app->bind(
            'App\Repositories\Contract\OrderItemRepositoryInterface',
            'App\Repositories\OrderItemRepository'
        );
        $this->app->bind(
            'App\Repositories\Contract\DashboardRepositoryInterface',
            'App\Repositories\DashboardRepository'
        );
    }
}
