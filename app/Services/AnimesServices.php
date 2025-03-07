<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Models\Anime;
use App\Models\AnimeFolder;
use Illuminate\Database\Eloquent\Collection;

class AnimesServices
{
    private ?Anime $anime = null;

    public function dataInCacheBySlug(string $slug)
    {
        return $this->anime = cache()->store('redis_animes')->flexible(CacheEnum::ANIME->value.$slug, [1200, 1800], function () use ($slug) {
            return Anime::query()
//                ->select([]) //TODO написать поля для выборки
                ->where('id', getIdFromSlug($slug))
                ->with(['type', 'countries', 'studios', 'genres'])
                ->firstOrFail();
        });
    }

    public function ratingUserFor(Anime|string|null $anime = null)
    {
        $this->checkModel($anime);

        return $this->anime->ratings()
            ->where('user_id', auth()->id())
            ->value('assessment') ?? 0;
    }

    public function favoriteUserFor(Anime|string|null $anime = null)
    {
        $this->checkModel($anime);

        return $this->anime->favorites()
            ->where('user_id', auth()->id())
            ->value('anime_folder_id');
    }

    public function foldersUserFor(): Collection
    {
        return AnimeFolder::query()
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

    public function checkModel(Anime|string|null $anime): void
    {
        if ($this->anime === null) {
            match (true) {
                $anime instanceof Anime => $this->anime = $anime,
                is_string($anime) => $this->anime = $this->dataInCacheBySlug($anime),
                default => throw new \InvalidArgumentException,
            };
        }
    }
}
