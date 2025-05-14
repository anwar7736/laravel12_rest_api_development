<?php

namespace App\Providers;

use App\Events\ProductCacheReset;
use App\Events\ProductCreated;
use App\Listeners\ResetProductCache;
use App\Listeners\SendProductCreatedNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            ProductCacheReset::class,
            ResetProductCache::class,
        );

        Event::listen(
            ProductCreated::class,
            SendProductCreatedNotification::class,
        );
    }
}
