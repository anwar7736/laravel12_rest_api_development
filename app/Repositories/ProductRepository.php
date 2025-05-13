<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Facade;

class ProductRepository implements ProductRepositoryInterface
{
    public static function get(Request $request)
    {
        $search = $request->search;
        $limit  = $request->limit ?? 50;
        return Product::when($search, function($query) use($search){
            $query->where('name', 'like', "%$search%")
                  ->orWhere('sku', 'like', "%$search%");
        })->paginate($limit);
    }

    public static function find(int $id)
    {
        return Product::findOrFail($id);
    }

    public static function store(Request $request)
    {
        $data = $request->only(['name', 'unit_id', 'warranty_id', 'dp_price', 'mrp_price', 'remarks']);
        $product = Product::create($data);
        if($request->brands)
        {
            $product->brands()->attach($request->brands);
        }

        if($request->categories)
        {
            $product->categories()->attach($request->categories);
        }

        $images_array = [];

        if($request->hasFile('images'))
        {
            foreach ($request->images as $key => $image) 
            {
                $imageName = uploadFile($image);
                $images_array[] = ['image' => $imageName];
            }
        }
        $product->images()->createMany($images_array);
        return $product;
    }

    public static function update(array $data, int $id)
    {
        return Product::find($id)->update($data);
    }

    public static function destroy(int $id)
    {
        return Product::find($id)->destroy();
    }
}
