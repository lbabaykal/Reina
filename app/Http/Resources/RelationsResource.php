<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class RelationsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'poster' => $this->posterUrl,
            'type' => TypesResource::make($this->type),
            'title_ru' => $this->title_ru,
            'episodes_total' => $this->episodes_total,
            'release' => Carbon::parse($this->release)->isoFormat('DD.MM.YYYY'),
            'rating' => $this->rating,
            'relation_type' => $this->getTable(),
        ];
    }
}
