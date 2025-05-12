<?php

namespace App\Http\Controllers;

use App\Facades\ProductServe;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $success = false;
            $data = [];
            $products = ProductServe::get($request);
            if($products){
                $success = true;
                $data = ProductResource::collection($products);
            }
            
            return apiResponse($success, '', $data);
        } catch (\Throwable $th) {
            return apiResponse(false, $th->getMessage());
        }
    }

    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $product = ProductServe::store($request->validated());
            DB::commit();
            return apiResponse(true, 'Product created successfully', new ProductResource($product));
        } catch (\Throwable $th) {
            DB::rollBack();
            return apiResponse(false, $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $success = false;
            $data = [];
            $product = ProductServe::find($id);
            if($product){
                $success = true;
                $data = new ProductResource($product);
            }
            return apiResponse($success, '', $data);
        } catch (\Throwable $th) {
            return apiResponse($success, $th->getMessage());
        }
    }


    public function update(ProductRequest $request, int $id)
    {
        try {
            DB::beginTransaction();
            $product = ProductServe::update($request->validated(), $id);
            DB::commit();
            return apiResponse(true, 'Product updated successfully', new ProductResource($product));
        } catch (\Throwable $th) {
            DB::rollBack();
            return apiResponse(false, $th->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            DB::beginTransaction();
            ProductServe::destroy($id);
            DB::commit();
            return apiResponse(true, 'Product deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return apiResponse(false, $th->getMessage());
        }
    }
}
