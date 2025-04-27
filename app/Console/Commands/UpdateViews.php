<?php

namespace App\Console\Commands;

use App\Models\Anime;
use App\Models\AnimeView;
use App\Models\Dorama;
use App\Models\DoramaView;
use Illuminate\Console\Command;

class UpdateViews extends Command
{
    protected $signature = 'update-views';

    protected $description = 'Обновление просмотров.';

    public function handle(): void
    {
        $startTime = microtime(true);
        $startMemory = memory_get_peak_usage(true);

        Anime::query()->select(['id'])->chunk(100, function ($animes) {
            $animeIds = $animes->pluck('id')->toArray();

            $views = AnimeView::query()
                ->selectRaw('anime_id, COUNT(*) as views')
                ->whereIn('anime_id', $animeIds)
                ->groupBy('anime_id')
                ->pluck('views', 'anime_id')
                ->toArray();

            $updates = [];

            foreach ($animeIds as $id) {
                $updates[] = [
                    'id' => $id,
                    'views' => $views[$id] ?? 0,
                ];
            }

            Anime::withoutTimestamps(function () use ($updates) {
                Anime::withoutEvents(function () use ($updates) {
                    foreach ($updates as $update) {
                        Anime::query()->where('id', $update['id'])->update([
                            'views' => $update['views'],
                        ]);
                    }
                });
            });
        });

        echo 'Просмотры Аниме обновлены.'.PHP_EOL;

        Dorama::query()->select(['id'])->chunk(100, function ($doramas) {
            $doramaIds = $doramas->pluck('id')->toArray();

            $views = DoramaView::query()
                ->selectRaw('dorama_id, COUNT(*) as views')
                ->whereIn('dorama_id', $doramaIds)
                ->groupBy('dorama_id')
                ->pluck('views', 'dorama_id')
                ->toArray();

            $updates = [];

            foreach ($doramaIds as $id) {
                $updates[] = [
                    'id' => $id,
                    'views' => $views[$id] ?? 0,
                ];
            }

            Dorama::withoutTimestamps(function () use ($updates) {
                Dorama::withoutEvents(function () use ($updates) {
                    foreach ($updates as $update) {
                        Dorama::query()->where('id', $update['id'])->update([
                            'views' => $update['views'],
                        ]);
                    }
                });
            });
        });

        echo 'Просмотры Дорам обновлены.'.PHP_EOL;

        $endTime = microtime(true);
        $endMemory = memory_get_peak_usage(true);

        $executionTime = round($endTime - $startTime, 2);
        $memoryUsage = round(($endMemory - $startMemory) / 1024 / 1024, 2);

        echo "Время выполнения: {$executionTime} seconds\n";
        echo "Памяти использовано: {$memoryUsage} MB\n";
    }
}
