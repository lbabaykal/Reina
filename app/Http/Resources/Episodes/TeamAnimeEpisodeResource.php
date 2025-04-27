<?php

namespace App\Http\Resources\Episodes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamAnimeEpisodeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->team->id,
            'name' => $this->team->name,
            'type' => $this->type->value,
            'link' => $this->link,
        ];
    }
}
