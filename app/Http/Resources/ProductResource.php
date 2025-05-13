<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'dp_price' => $this->dp_price,
            'mrp_price' => $this->mrp_price,
            'unit' => $this->unit,
            'warranty' => $this->warranty,
            'brands' => $this->brands,
            'categories' => $this->categories,
            'images' => $this->images,
        ];
    }
}
