<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'max:30'],
            'phone'    => ['required', 'unique:users,phone'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:4'],
            'address'  => ['nullable', 'max:50'],
            'image'    => ['nullable', 'image:mimes:jpeg,jpg,png,webp,svg', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [

        ];
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
