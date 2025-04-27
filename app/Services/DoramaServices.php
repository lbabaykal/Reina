<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Models\Dorama;

class DoramaServices
{
    private ?Dorama $dorama = null;

    public function getDataFromCacheById(int $id)
    {
        return $this->dorama = cache()
            ->store(CacheEnum::DORAMAS_STORE->value)
            ->flexible(CacheEnum::DORAMA->value.$id, [1200, 1800], function () use ($id) {
                return Dorama::query()
//                ->select([])  //TODO написать поля для выборки
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

    public function ratingUserFor(Dorama|string|int|null $dorama = null): ?int
    {
        $this->checkModel($dorama);

        return $this->dorama->ratings()
            ->where('user_id', auth()->id())
            ->value('assessment');
    }

    public function favoriteUserFor(Dorama|string|int|null $dorama = null): object
    {
        $this->checkModel($dorama);

        $favorite = $this->dorama->favorites()->select(['dorama_folder_id', 'dorama_episode_id'])->first();

        return (object) [
            'dorama_folder_id' => $favorite?->dorama_folder_id,
            'dorama_episode_id' => $favorite?->dorama_episode_id,
        ];
    }

    //    public function episodesFor(Dorama|string|int|null $dorama = null): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    //    {
    //        $this->checkModel($dorama);
    //
    //        return new EpisodeServices()->episodesForDoramaById($this->dorama->id);
    //    }
    //
    //    public function relationsFor(Dorama|string|int|null $dorama = null): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    //    {
    //        $this->checkModel($dorama);
    //
    //        if (is_null($this->dorama->franchise_id)) {
    //            return collect();
    //        }
    //
    //        return new FranchiseServices()->relationsForDoramaById($this->dorama->franchise_id);
    //    }

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
