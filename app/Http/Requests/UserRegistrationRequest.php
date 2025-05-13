<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'max:30'],
            'phone'    => ['required', 'unique:users,phone'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:4'],
            'image'    => ['nullable', 'image:mimes:jpeg,jpg,png,webp,svg', 'max:2048'],
            'address'  => ['nullable', 'max:50'],
        ];
    }
}
