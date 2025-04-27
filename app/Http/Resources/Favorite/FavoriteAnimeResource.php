<?php

namespace App\Http\Resources\Favorite;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteAnimeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'anime_id' => $this->anime_id,
            'folder_id' => $this->anime_folder_id,
            'episode_id' => $this->anime_episode_id,
        ];
    }
}
