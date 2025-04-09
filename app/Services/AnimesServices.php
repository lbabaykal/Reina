<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Enums\StatusEnum;
use App\Models\Anime;
use Illuminate\Database\Eloquent\Collection;

class AnimesServices
{
    private ?Anime $anime = null;

    public function getDataFromCacheById(int $id)
    {
        return $this->anime = cache()
            ->store(CacheEnum::ANIMES_STORE->value)
            ->flexible(CacheEnum::ANIME->value.$id, [1200, 1800], function () use ($id) {
                return Anime::query()
//            ->select([]) //TODO написать поля для выборки
                    ->with(['type', 'countries', 'studios', 'genres'])
                    ->findOrFail($id);
            });
    }

    public function getDataFromCacheBySlug(string $slug)
    {
        $id = getIdFromSlug($slug);

        return $this->getDataFromCacheById($id);
    }

    public function ratingUserFor(Anime|string|int|null $anime = null): int
    {
        $this->checkModel($anime);

        return $this->anime->ratings()
            ->where('user_id', auth()->id())
            ->value('assessment') ?? 0;
    }

    public function favoriteUserFor(Anime|string|int|null $anime = null): object
    {
        $this->checkModel($anime);

        $favoriteUser = $this->anime->favorites()->first();

        if (! $favoriteUser) {
            return (object) [
                'anime_folder_id' => 0,
                'anime_episode_id' => 0,
            ];
        }

        return (object) [
            'anime_folder_id' => $favoriteUser->anime_folder_id,
            'anime_episode_id' => $favoriteUser->anime_episode_id,
        ];
    }

    public function episodesFor(Anime|string|int|null $anime = null): Collection
    {
        $this->checkModel($anime);

        return cache()
            ->store(CacheEnum::ANIMES_STORE->value)
            ->flexible(CacheEnum::ANIME_EPISODES->value.$this->anime->id, [1200, 1800], function () {
                return $this->anime->episodes()
                    ->select('id', 'title_org', 'title_ru', 'title_en', 'release_date', 'status')
                    ->where('status', StatusEnum::PUBLISHED)
                    ->orderBy('release_date')
                    ->get();
            });
    }

    protected function checkModel(Anime|string|int|null $anime): void
    {
        if ($this->anime === null) {
            match (true) {
                $anime instanceof Anime => $this->anime = $anime,
                is_string($anime) => $this->anime = $this->getDataFromCacheBySlug($anime),
                is_int($anime) => $this->anime = $this->getDataFromCacheById($anime),
                default => throw new \InvalidArgumentException,
            };
        }
    }
}
