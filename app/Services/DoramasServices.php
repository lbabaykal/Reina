<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Models\Dorama;
use App\Models\FavoriteDorama;

class DoramasServices
{
    private ?Dorama $dorama = null;

    private ?int $ratingUser = null;

    private FavoriteDorama $favoriteUser;

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

    public function ratingUserFor(Dorama|string|null $dorama = null): int
    {
        $this->checkModel($dorama);

        return $this->ratingUser = $this->dorama->ratings()
            ->where('user_id', auth()->id())
            ->value('assessment') ?? 0;
    }

    public function favoriteUserFor(Dorama|string|null $dorama = null): FavoriteDorama
    {
        $this->checkModel($dorama);

        return $this->favoriteUser = $this->dorama->favorites()
            ->firstOrNew([
                'user_id' => auth()->id(),
            ], [
                'dorama_folder_id' => 0,
                'episode' => 0,
            ]);
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
