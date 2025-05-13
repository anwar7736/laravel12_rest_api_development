<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'min:3', 'max:50', 'unique:products,name'],
            'dp_price'      => ['required', 'min:1', 'numeric'],
            'mrp_price'     => ['required', 'min:1', 'numeric'],
            'unit_id'       => ['required', 'numeric'],
            'warranty_id'   => ['required', 'numeric'],
            // 'brands.*'      => ['required'],
            // 'categories.*'  => ['required'],
            // 'images.*'      => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,svg'],
            'remarks'       => ['nullable', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422));
    }
}
