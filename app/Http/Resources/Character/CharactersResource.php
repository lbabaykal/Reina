<?php

namespace App\Http\Resources\Character;

use App\Models\CharacterRole;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharactersResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if ($this->resource->isEmpty()) {
            return [];
        }

        $roleSlugs = new CharacterRole()->cache();

        $characters = $this->resource;

        $grouped = $characters->groupBy(fn($character) => $character->characterRole->slug);

        $result = [];

        foreach ($roleSlugs as $roleSlug) {
            $items = $grouped->get($roleSlug->slug, collect())
                ->map(fn($character) => new CharacterResource($character->character))
                ->values();

            $result[$roleSlug->slug] = $items->isNotEmpty() ? $items : null;
        }

        return $result;
    }
}
