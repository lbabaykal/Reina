<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Enums\StatusEnum;
use App\Models\Anime;
use App\Models\Dorama;

class EpisodeServices
{
    public function episodesForAnimeById(int $id): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    {
        $anime = Anime::query()
            ->select(['id'])
            ->findOrFail($id);

        return cache()->store(CacheEnum::ANIMES_STORE->value)
            ->flexible(CacheEnum::ANIME_EPISODES->value.$id, [1200, 1800], function () use ($anime) {
                return $anime->episodes()
                    ->select(['id', 'name_org', 'name_ru', 'name_en', 'release_date', 'status'])
                    ->where('status', StatusEnum::PUBLISHED)
                    ->whereHas('teamAnimeEpisodes', function ($query) {
                        $query->where('status', StatusEnum::PUBLISHED);
                    })
                    ->orderBy('release_date')
                    ->with([
                        'teamAnimeEpisodes' => function ($query) {
                            $query->where('status', StatusEnum::PUBLISHED)->orderBy('team_id');
                        },
                        'teamAnimeEpisodes.team:id,name',
                    ])
                    ->get();
            });
    }

    public function episodesForDoramaById(int $id): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    {
        $dorama = Dorama::query()
            ->select(['id'])
            ->findOrFail($id);

        return cache()->store(CacheEnum::DORAMAS_STORE->value)
            ->flexible(CacheEnum::DORAMAS_EPISODES->value.$id, [1200, 1800], function () use ($dorama) {
                return $dorama->episodes()
                    ->select(['id', 'name_org', 'name_ru', 'name_en', 'release_date', 'status'])
                    ->where('status', StatusEnum::PUBLISHED)
                    ->whereHas('teamDoramaEpisodes', function ($query) {
                        $query->where('status', StatusEnum::PUBLISHED);
                    })
                    ->orderBy('release_date')
                    ->with([
                        'teamDoramaEpisodes' => function ($query) {
                            $query->where('status', StatusEnum::PUBLISHED)->orderBy('team_id');
                        },
                        'teamDoramaEpisodes.team:id,name',
                    ])
                    ->get();
            });
    }
}
