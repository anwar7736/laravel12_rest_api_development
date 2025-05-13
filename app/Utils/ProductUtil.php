<?php

namespace App\Utils;

use App\Facades\ProductRepo;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

class ProductUtil extends Facade
{
    public static function get(Request $request)
    {
        try {
            return ProductRepository::get($request);
        } catch (\Throwable $th) {
           return $th->getMessage();
        }
    }

    public static function find(int $id)
    {
        try {
            return ProductRepository::find($id);
        } catch (\Throwable $th) {
           return $th->getMessage();
        }
    }

    public static function store(Request $request)
    {
        try {
            return ProductRepository::store($request);
        } catch (\Throwable $th) {
           return $th->getMessage();
        }
    }

    public static function update(array $data, int $id)
    {
        try {
            return ProductRepository::update($data, $id);
        } catch (\Throwable $th) {
           return $th->getMessage();
        }
    }

    public static function destroy(int $id)
    {
        try {
            return ProductRepository::destroy($id);
        } catch (\Throwable $th) {
           return $th->getMessage();
        }
    }

}
