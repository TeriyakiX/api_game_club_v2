<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TournamentStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'date' => 'required|max:255'
        ];
    }
}
