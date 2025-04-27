<?php

namespace App\Http\Resources\Episodes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoramaEpisodesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name_org' => $this->name_org,
            'name_ru' => $this->name_ru,
            'name_en' => $this->name_en,
            'release_date' => $this->release_date,
            'teams' => TeamDoramaEpisodeResource::collection($this->whenLoaded('teamDoramaEpisodes')),
        ];
    }
}
