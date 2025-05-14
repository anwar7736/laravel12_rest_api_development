<?php

namespace App\Listeners;

use App\Events\ProductCacheReset;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class ResetProductCache
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductCacheReset $event): void
    {
        Cache::forget('products');
        Product::cashed_products();
    }
}
