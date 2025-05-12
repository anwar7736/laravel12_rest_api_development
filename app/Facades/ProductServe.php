<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ProductServe extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "product_service";
    }
}
