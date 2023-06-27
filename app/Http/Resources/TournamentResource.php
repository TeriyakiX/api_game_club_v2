<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TournamentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'game' => $this->game,
            'Short_description' => $this->Short_description,
            'description' => $this->description,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'prize' => $this->prize,
            'type_id' => $this->type_id,
            'status_id' => $this->status_id,
        ];
    }
}
