<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Models\Dorama;
use App\Models\DoramaFolder;
use Illuminate\Database\Eloquent\Collection;

class DoramasServices
{
    private ?Dorama $dorama = null;

    public function dataInCacheBySlug(string $slug)
    {
        return $this->dorama = cache()->store('redis_doramas')->flexible(CacheEnum::DORAMA->value.$slug, [1200, 1800], function () use ($slug) {
            return Dorama::query()
//                ->select([])  //TODO написать поля для выборки
                ->where('id', getIdFromSlug($slug))
                ->with(['type', 'countries', 'studios', 'genres'])
                ->firstOrFail();
        });
    }

    public function ratingUserFor(Dorama|string|null $dorama = null)
    {
        $this->checkModel($dorama);

        return $this->dorama->ratings()
            ->where('user_id', auth()->id())
            ->value('assessment') ?? 0;
    }

    public function favoriteUserFor(Dorama|string|null $dorama = null)
    {
        $this->checkModel($dorama);

        return $this->dorama->favorites()
            ->where('user_id', auth()->id())
            ->value('dorama_folder_id');
    }

    public function foldersUserFor(): Collection
    {
        return DoramaFolder::query()
            ->select(['id', 'title'])
            ->where('user_id', auth()->id())
            ->orWhere('user_id', 0)
            ->orderBy('id')
            ->get();
    }

    public function userFolderFavorite()
    {
        return $this->foldersUserFor()->firstWhere('id', $this->favoriteUserFor())
            ?? (object) [
                'id' => 0,
                'title' => '',
            ];
    }

    public function checkModel(Dorama|string|null $dorama): void
    {
        if ($this->dorama === null) {
            match (true) {
                $dorama instanceof Dorama => $this->dorama = $dorama,
                is_string($dorama) => $this->dorama = $this->dataInCacheBySlug($dorama),
                default => throw new \InvalidArgumentException,
            };
        }
    }
}
