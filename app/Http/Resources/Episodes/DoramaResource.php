<?php

namespace App\Http\Resources\Episodes;

use App\Http\Resources\GenresResource;
use App\Http\Resources\TypesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoramaResource extends JsonResource
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
            'number' => $this->number,
            'dorama_id' => $this->anime_id,
            'title_org' => $this->title_org,
            'title_ru' => $this->title_ru,
            'title_en' => $this-> title_en,
            'release_date' => $this->release_date,
        ];
    }

}
