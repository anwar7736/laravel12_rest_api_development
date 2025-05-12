<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ProductRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "product_repository";
    }
}
