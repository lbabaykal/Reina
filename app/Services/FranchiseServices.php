<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Models\Anime;
use App\Models\Dorama;
use App\Models\Franchise;

class FranchiseServices
{
    public function relationsForAnimeById(int $animeId): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    {
        $anime = Anime::query()
            ->select(['id', 'franchise_id'])
            ->findOrFail($animeId);

        if (is_null($anime->franchise_id)) {
            return collect();
        }

        return $this->findAllRelations($anime->franchise_id);
    }

    public function relationsForDoramaById(int $doramaId): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    {
        $dorama = Dorama::query()
            ->select(['id', 'franchise_id'])
            ->findOrFail($doramaId);

        if (is_null($dorama->franchise_id)) {
            return collect();
        }

        return $this->findAllRelations($dorama->franchise_id);
    }

    protected function findAllRelations(int $franchiseId): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    {
        $franchiseRelations = cache()
            ->store(CacheEnum::DIFFERENT_STORE->value)
            ->flexible(CacheEnum::FRANCHISE->value.$franchiseId, [1200, 1800], function () use ($franchiseId) {
                return Franchise::query()
                    ->with([
                        'animes:id,slug,poster,type_id,title_ru,release,rating,franchise_id,episodes_total' => ['type'],
                        'doramas:id,slug,poster,type_id,title_ru,release,rating,franchise_id,episodes_total' => ['type'],
                    ])
                    ->find($franchiseId);
            });

        if (! $franchiseRelations) {
            return collect();
        }

        return $franchiseRelations->animes->concat($franchiseRelations->doramas)->sortBy('release');
    }
}
