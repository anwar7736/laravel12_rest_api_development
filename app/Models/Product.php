<?php

namespace App\Models;

use App\Traits\ModelActionCauser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory, SoftDeletes, ModelActionCauser;
    protected $guarded = ['id'];
    const IMAGE_PATH = "products";

    public function unit()
    {
        return $this->belongsTo(Unit::class)->select('id', 'name');
    }

    public function warranty()
    {
        return $this->belongsTo(Warranty::class)->select('id', 'name', 'type', 'count');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function deletor()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }

    public function setSkuAttribute($value)
    {
        $this->attributes['sku'] = "SKU-" . rand(11111, 99999);
    }

    public static function cashed_products()
    {
        $products = Cache::rememberForever('products', function () {
            return Product::with(['unit', 'warranty', 'brands', 'categories', 'images'])
                ->select('id', 'unit_id', 'warranty_id', 'name', 'sku', 'dp_price', 'mrp_price')
                ->get();
        });
        return $products;
    }
}
