<?php

namespace App\Http\Resources\Favorite;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'poster' => $this->posterUrl,
            'title' => $this->title_ru,
            'rating' => $this->rating,
            'episodes_released' => $this->episodes_released,
            'episodes_total' => $this->episodes_total,
            'is_rating' => $this->is_rating,
        ];
    }
}
