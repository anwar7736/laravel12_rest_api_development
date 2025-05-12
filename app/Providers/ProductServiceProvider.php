<?php

namespace App\Providers;

use App\Utils\ProductUtil;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        app()->bind('product_service', function(){
            return new ProductUtil;
        });

        app()->bind('product_repository', function(){
            return new ProductRepository;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
