<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ProductUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'name'          => ['required', 'min:3', 'max:50', 'unique:products,name,'.$id],
            'dp_price'      => ['required', 'min:1', 'numeric'],
            'mrp_price'     => ['required', 'min:1', 'numeric'],
            'unit_id'       => ['required', 'numeric'],
            'warranty_id'   => ['required', 'numeric'],
            'brands'        => ['required', 'array'],
            'categories'    => ['required', 'array'],
            'images'        => ['nullable', 'array', 'image', 'mimes:png,jpg,jpeg,webp,svg'],
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
