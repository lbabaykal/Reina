<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'full_name_org' => $this->full_name_org,
            'full_name_ru' => $this->full_name_ru,
            'full_name_en' => $this->full_name_en,
            'photo' => $this->photoUrl,
            'role' => $this->pivot?->role,
        ];
    }
}
