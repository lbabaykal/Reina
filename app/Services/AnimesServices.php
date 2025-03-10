<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Models\Anime;
use App\Models\FavoriteAnime;

class AnimesServices
{
    private ?Anime $anime = null;

    private ?int $ratingUser = null;

    private FavoriteAnime $favoriteUser;

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

    public function ratingUserFor(Anime|string|null $anime = null): int
    {
        $this->checkModel($anime);

        return $this->ratingUser = $this->anime->ratings()
            ->where('user_id', auth()->id())
            ->value('assessment') ?? 0;
    }

    public function favoriteUserFor(Anime|string|null $anime = null): FavoriteAnime
    {
        $this->checkModel($anime);

        return $this->favoriteUser = $this->anime->favorites()
            ->firstOrNew([
                'user_id' => auth()->id(),
            ], [
                'anime_folder_id' => 0,
                'episode' => 0,
            ]);
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
