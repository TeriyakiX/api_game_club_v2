<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Applications_the_tournamentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_tournament' => 'required|max:255',
            'id_user' => 'required|max:255',
            'date_created_at' => 'required|max:255',
            'id_approved_or_not' => 'required|max:255',
        ];
    }
}
