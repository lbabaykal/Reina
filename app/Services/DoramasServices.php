<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Enums\StatusEnum;
use App\Models\Dorama;
use Illuminate\Database\Eloquent\Collection;

class DoramasServices
{
    private ?Dorama $dorama = null;

    public function getDataFromCacheById(int $id)
    {
        return $this->dorama = cache()
            ->store(CacheEnum::DORAMAS_STORE->value)
            ->flexible(CacheEnum::DORAMA->value.$id, [1200, 1800], function () use ($id) {
                return Dorama::query()
//                ->select([])  //TODO написать поля для выборки
                    ->with(['type', 'countries', 'studios', 'genres'])
                    ->findOrFail($id);
            });
    }

    public function getDataFromCacheBySlug(string $slug)
    {
        $id = getIdFromSlug($slug);

        return $this->getDataFromCacheById($id);
    }

    public function ratingUserFor(Dorama|string|int|null $dorama = null): int
    {
        $this->checkModel($dorama);

        return $this->dorama->ratings()
            ->where('user_id', auth()->id())
            ->value('assessment') ?? 0;
    }

    public function favoriteUserFor(Dorama|string|int|null $dorama = null): object
    {
        $this->checkModel($dorama);

        $favoriteUser = $this->dorama->favorites()->first();

        if (! $favoriteUser) {
            return (object) [
                'dorama_folder_id' => 0,
                'dorama_episode_id' => 0,
            ];
        }

        return (object) [
            'dorama_folder_id' => $favoriteUser->dorama_folder_id,
            'dorama_episode_id' => $favoriteUser->dorama_episode_id,
        ];
    }

    public function episodesFor(Dorama|string|int|null $dorama = null): Collection
    {
        $this->checkModel($dorama);

        return cache()
            ->store(CacheEnum::DORAMAS_STORE->value)
            ->flexible(CacheEnum::DORAMAS_EPISODES->value.$this->dorama->id, [1200, 1800], function () {
                return $this->dorama->episodes()
                    ->select('id', 'title_org', 'title_ru', 'title_en', 'release_date', 'status')
                    ->where('status', StatusEnum::PUBLISHED)
                    ->orderBy('release_date')
                    ->get();
            });
    }

    protected function checkModel(Dorama|string|int|null $dorama): void
    {
        if ($this->dorama === null) {
            match (true) {
                $dorama instanceof Dorama => $this->dorama = $dorama,
                is_string($dorama) => $this->dorama = $this->getDataFromCacheBySlug($dorama),
                is_int($dorama) => $this->dorama = $this->getDataFromCacheById($dorama),
                default => throw new \InvalidArgumentException,
            };
        }
    }
}
