<?php

namespace App\Http\Resources\Favorite;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteDoramaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'dorama_id' => $this->dorama_id,
            'folder_id' => $this->dorama_folder_id,
            'episode_id' => $this->dorama_episode_id,
        ];
    }
}
