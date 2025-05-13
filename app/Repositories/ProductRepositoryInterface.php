<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public static function get(Request $request);
    public static function find(int $id);
    public static function store(Request $request);
    public static function update(array $data, int $id);
    public static function destroy(int $id);
}
