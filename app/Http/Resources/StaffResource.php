<?php

namespace App\Http\Resources;

use App\Http\Resources\Person\PersonResource;
use App\Models\PersonRole;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if ($this->resource->isEmpty()) {
            return [];
        }

        $roleSlugs = new PersonRole()->cache();

        $persons = $this->resource;

        $grouped = $persons->groupBy(fn($person) => $person->personRole->slug);

        $result = [];

        foreach ($roleSlugs as $roleSlug) {
            $items = $grouped->get($roleSlug->slug, collect())
                ->map(fn($person) => new PersonResource($person->person))
                ->values();

            $result[$roleSlug->slug] = $items->isNotEmpty() ? $items : null;
        }

        return $result;
    }
}
