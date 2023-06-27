<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TournamentStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'game' => 'required|max:255',
            'Short_description' => 'required|max:255',
            'description' => 'required|max:255',
            'date_start' => 'required|max:255',
            'date_end' => 'required|max:255',
            'prize' => 'required|max:255',
            'type_id' => 'required|max:255',
            'status_id' => 'required|max:255'
        ];
    }
}
