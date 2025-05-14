<?php

namespace App\Repositories;

use App\Events\ProductCacheReset;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;

class ProductRepository implements ProductRepositoryInterface
{
    public static function get(Request $request)
    {
        $search = $request->search;
        $limit  = $request->limit ?? 50;

        $products = Product::cashed_products();
        // Collection filtering
        if ($search) {
            $products = $products->filter(function ($item) use ($search) {
                return str_contains(strtolower($item->name), strtolower($search)) ||
                    str_contains(strtolower($item->sku), strtolower($search));
            });
        }

        // Manual pagination
        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginated = new LengthAwarePaginator(
            $products->forPage($page, $limit)->values(),
            $products->count(),
            $limit,
            $page
        );

        return $paginated;
    }

    public static function find(int $id)
    {
        return Product::findOrFail($id);
    }

    public static function store(Request $request)
    {
        $data = $request->only(['name', 'unit_id', 'warranty_id', 'dp_price', 'mrp_price', 'remarks']);
        $product = Product::create($data);
        if ($request->brands) {
            $product->brands()->attach($request->brands);
        }

        if ($request->categories) {
            $product->categories()->attach($request->categories);
        }

        $images_array = [];

        if ($request->hasFile('images')) {
            foreach ($request->images as $key => $image) {
                $imageName = uploadFile($image, Product::IMAGE_PATH);
                $images_array[] = ['image' => $imageName];
            }
        }
        if ($images_array) {
            $product->images()->createMany($images_array);
        }
        return $product;
    }

    public static function update(Request $request, int $id)
    {
        $data = $request->only(['name', 'unit_id', 'warranty_id', 'dp_price', 'mrp_price', 'remarks']);
        $product = Product::find($id)->update($data);
        if ($request->brands) {
            $product->brands()->sync($request->brands);
        }

        if ($request->categories) {
            $product->categories()->sync($request->categories);
        }

        $images_array = [];

        if ($request->hasFile('images')) {
            foreach ($request->images as $key => $image) {
                $imageName = uploadFile($image, Product::IMAGE_PATH);
                $images_array[] = ['image' => $imageName];
            }
        }
        if ($images_array) {
            $product->images->map(function ($row) {
                deleteFile($row->image, Product::IMAGE_PATH);
                $row->delete();
            });
            $product->images()->createMany($images_array);
        }
        return $product;
    }

    public static function destroy(int $id)
    {
        $product = Product::find($id);
        $product->brands()->delete();
        $product->categories()->delete();
        $product->images->map(function ($row) {
            deleteFile($row->image, Product::IMAGE_PATH);
            $row->delete();
        });
        $data = clone $product;
        $product->delete();
        return $data;
    }
}
