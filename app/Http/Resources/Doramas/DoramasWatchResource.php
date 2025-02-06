<?php

namespace App\Http\Resources\Doramas;

use App\Http\Resources\GenresResource;
use App\Http\Resources\TypesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoramasWatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title_org' => $this->title_org,
            'title_ru' => $this->title_ru,
            'title_en' => $this->title_en,
            'types' => TypesResource::make($this->type),
            'genres' => GenresResource::collection($this->genres),
            'age_rating' => $this->age_rating,
            'episodes_released' => $this->episodes_released,
            'episodes_total' => $this->episodes_total,
            'rating' => $this->rating,
            'count_assessments' => $this->count_assessments,
            'is_comment' => $this->is_comment,
            'is_rating' => $this->is_rating,
        ];
    }

}
