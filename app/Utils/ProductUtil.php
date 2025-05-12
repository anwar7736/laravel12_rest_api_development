<?php

namespace App\Utils;

use App\Facades\ProductRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

class ProductUtil extends Facade
{
    public function get(Request $request)
    {
        try {
            return ProductRepo::get($request);
        } catch (\Throwable $th) {
           return $th->getMessage();
        }
    }

    public function find(int $id)
    {
        try {
            return ProductRepo::find($id);
        } catch (\Throwable $th) {
           return $th->getMessage();
        }
    }

    public function store(array $data)
    {
        try {
            return ProductRepo::store($data);
        } catch (\Throwable $th) {
           return $th->getMessage();
        }
    }

    public function update(array $data, int $id)
    {
        try {
            return ProductRepo::update($data, $id);
        } catch (\Throwable $th) {
           return $th->getMessage();
        }
    }

    public function destroy(int $id)
    {
        try {
            return ProductRepo::destroy($id);
        } catch (\Throwable $th) {
           return $th->getMessage();
        }
    }

}
