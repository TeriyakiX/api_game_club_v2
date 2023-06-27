<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Applications_the_tournamentResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_tournament' => $this->id_tournament,
            'id_user' => $this->id_user,
            'date_created_at' => $this->date_created_at,
            'id_approved_or_not' => $this->id_approved_or_not,
        ];
    }
}
