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
            'dorama_id' => $this->dorama_id,
            'title_org' => $this->title_org,
            'title_ru' => $this->title_ru,
            'title_en' => $this->title_en,
            'release_date' => $this->release_date,
            'voices' => [],
        ];
    }
}
