<?php

namespace App\Http\Controllers;

use App\Events\ProductCacheReset;
use App\Events\ProductCreated;
use App\Events\ProductDeleted;
use App\Events\ProductStored;
use App\Events\ProductUpdated;
use App\Facades\ProductServe;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Utils\ProductUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $success = false;
            $data = [];
            $products = ProductUtil::get($request);
            if ($products) {
                $success = true;
                $data = ProductResource::collection($products);
            }

            return apiResponse($success, '', $data);
        } catch (\Throwable $th) {
            return apiResponse(false, $th->getMessage());
        }
    }

    public function store(ProductStoreRequest $request)
    {
        // return $request->all();
        try {
            DB::beginTransaction();
            $product = ProductUtil::store($request);
            DB::commit();
            event(new ProductCacheReset());
            event(new ProductCreated($product));
            broadcast(new ProductStored($product))->toOthers();
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
            $product = ProductUtil::find($id);
            if ($product) {
                $success = true;
                $data = new ProductResource($product);
            }
            return apiResponse($success, '', $data);
        } catch (\Throwable $th) {
            return apiResponse($success, $th->getMessage());
        }
    }


    public function update(ProductUpdateRequest $request, int $id)
    {
        try {
            DB::beginTransaction();
            $product = ProductUtil::update($request->validated(), $id);
            DB::commit();
            event(new ProductCacheReset());
            broadcast(new ProductUpdated($product))->toOthers();
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
            $product = ProductUtil::destroy($id);
            DB::commit();
            event(new ProductCacheReset());
            broadcast(new ProductDeleted($product))->toOthers();
            return apiResponse(true, 'Product deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return apiResponse(false, $th->getMessage());
        }
    }
}
