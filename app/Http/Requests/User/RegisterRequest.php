<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'login' => 'required|string|unique:users',
            'password' => 'required|string',
            'role_id' => 'required|integer|exists:users,id',
        ];
    }
}
