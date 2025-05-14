<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteProducts extends Command
{
    protected $signature = 'delete:soft-deleted-products';

    protected $description = 'Delete Soft Deleted Products Everyday';

    public function handle()
    {
        try {
            DB::beginTransaction();
            $products = Product::onlyTrashed()->get();
            $count = 0;
            $products->map(function ($product) use ($count) {
                if ($product->images->count()) {
                    $product->images->map(function ($item) {
                        deleteFile($item->image, Product::IMAGE_PATH);
                        $item->delete();
                    });
                }
                $product->brands()->delete();
                $product->categories()->delete();
                $product->delete();
                $count++;
            });
            DB::commit();
            Log::info("Product Delete Notes: Total $count products has been deleted by schedular.");
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Errors: " . $th->getMessage());
        }
    }
}
