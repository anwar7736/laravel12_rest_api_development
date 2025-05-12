<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:50', 'unique:products, name'],
            'sku' => ['required', 'min:3', 'max:50', 'unique:products, sku'],
        ];
    }
}
