<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function get(Request $request);
    public function find(int $id);
    public function store(array $data);
    public function update(array $data, int $id);
    public function destroy(int $id);
}
