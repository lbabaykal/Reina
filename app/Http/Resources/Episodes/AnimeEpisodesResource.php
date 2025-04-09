<?php

namespace App\Http\Resources\Episodes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimeEpisodesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'anime_id' => $this->anime_id,
            'title_org' => $this->title_org,
            'title_ru' => $this->title_ru,
            'title_en' => $this->title_en,
            'release_date' => $this->release_date,
            'voices' => ['Команда А', 'Команда B', 'Команда C', 'Команда D', 'Команда E', 'Команда F', 'Команда А', 'Команда B', 'Команда C', 'Команда D', 'Команда E', 'Команда F', 'Команда А', 'Команда B', 'Команда C', 'Команда D', 'Команда E', 'Команда F', 'Команда А', 'Команда B', 'Команда C', 'Команда D', 'Команда E', 'Команда F'],
        ];
    }
}
