<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Models\Anime;

class AnimeServices
{
    private ?Anime $anime = null;

    public function getDataFromCacheById(int $id)
    {
        return $this->anime = cache()
            ->store(CacheEnum::ANIMES_STORE->value)
            ->flexible(CacheEnum::ANIME->value.$id, [1200, 1800], function () use ($id) {
                return Anime::query()
//                    ->select([]) // TODO написать поля для выборки
                    ->with([
                        'type:id,slug,title_ru,title_en',
                        'countries:id,slug,title_ru,title_en',
                        'studios:id,slug,title',
                        'genres:id,slug,title_ru,title_en',
                        'franchise',
                    ])->findOrFail($id);
            });
    }

    public function getDataFromCacheBySlug(string $slug)
    {
        return $this->getDataFromCacheById(getIdFromSlug($slug));
    }

    public function ratingUserFor(Anime|string|int|null $anime = null): ?int
    {
        $this->checkModel($anime);

        return $this->anime->ratings()
            ->where('user_id', auth()->id())
            ->value('assessment');
    }

    public function favoriteUserFor(Anime|string|int|null $anime = null): object
    {
        $this->checkModel($anime);

        $favorite = $this->anime->favorites()->select(['id', 'anime_id', 'anime_folder_id', 'anime_episode_id'])->first();

        return (object) [
            'id' => $favorite?->id,
            'anime_id' => $favorite?->anime_id,
            'anime_folder_id' => $favorite?->anime_folder_id,
            'anime_episode_id' => $favorite?->anime_episode_id,
        ];
    }

    //    public function episodesFor(Anime|string|int|null $anime = null): \Illuminate\Database\Eloquent\Collection
    //    {
    //        $this->checkModel($anime);
    //
    //        return new EpisodeServices()->episodesForAnimeById($this->anime->id);
    //    }
    //
    //    public function relationsFor(Anime|string|int|null $anime = null): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    //    {
    //        $this->checkModel($anime);
    //
    //        if (is_null($this->anime->franchise_id)) {
    //            return collect();
    //        }
    //
    //        return new FranchiseServices()->relationsForAnimeById($this->anime->franchise_id);
    //    }

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
