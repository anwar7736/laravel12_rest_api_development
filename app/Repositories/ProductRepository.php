<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Facade;

class ProductRepository implements ProductRepositoryInterface
{
    public function get(Request $request)
    {
        $search = $request->search;
        $limit  = $request->limit ?? 50;
        return Product::when($search, function($query) use($search){
            $query->where('name', 'like', "%$search%")
                  ->orWhere('sku', 'like', "%$search%");
        })->paginate($limit);
    }

    public function find(int $id)
    {
        return Product::findOrFail($id);
    }

    public function store(array $data)
    {
        $product = Product::create($data);
        return $product;
    }

    public function update(array $data, int $id)
    {
        return Product::find($id)->update($data);
    }

    public function destroy(int $id)
    {
        return Product::find($id)->destroy();
    }
}
