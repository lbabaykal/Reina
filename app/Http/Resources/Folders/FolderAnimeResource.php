<?php

namespace App\Http\Resources\Folders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FolderAnimeResource extends JsonResource
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
            'name' => $this->name,
            'user_id' => $this->user_id,
            'favorites_animes_user_count' => $this->favorites_animes_user_count,
        ];
    }
}
