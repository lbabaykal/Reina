<?php

namespace App\Console\Commands;

use App\Enums\CacheEnum;
use App\Models\Anime;
use App\Models\AnimeRating;
use App\Models\AnimeRatingStatistic;
use App\Models\Dorama;
use App\Models\DoramaRating;
use App\Models\DoramaRatingStatistic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateRating extends Command
{
    protected $signature = 'update-rating';

    protected $description = 'Обновление рейтинга.';

    public function handle(): void
    {
        $startTime = microtime(true);
        $startMemory = memory_get_peak_usage(true);

        foreach (Anime::query()
            ->withoutGlobalScopes()
            ->select(['id', 'rating', 'count_assessments'])
            ->cursor() as $anime) {

            $animeRating = AnimeRating::query()->select(
                DB::raw('SUM((assessment = 1)::int) as assessment_1'),
                DB::raw('SUM((assessment = 2)::int) as assessment_2'),
                DB::raw('SUM((assessment = 3)::int) as assessment_3'),
                DB::raw('SUM((assessment = 4)::int) as assessment_4'),
                DB::raw('SUM((assessment = 5)::int) as assessment_5'),
                DB::raw('SUM((assessment = 6)::int) as assessment_6'),
                DB::raw('SUM((assessment = 7)::int) as assessment_7'),
                DB::raw('SUM((assessment = 8)::int) as assessment_8'),
                DB::raw('SUM((assessment = 9)::int) as assessment_9'),
                DB::raw('SUM((assessment = 10)::int) as assessment_10'),
                DB::raw('COUNT(*) as count_assessments'),
                DB::raw('ROUND(AVG(assessment), 2) as rating')
            )
                ->where('anime_id', $anime->id)
                ->groupBy('anime_id')
                ->first();

            AnimeRatingStatistic::query()
                ->where('anime_id', $anime->id)
                ->first()->update([
                    'assessment_1' => $animeRating->assessment_1 ?? 0,
                    'assessment_2' => $animeRating->assessment_2 ?? 0,
                    'assessment_3' => $animeRating->assessment_3 ?? 0,
                    'assessment_4' => $animeRating->assessment_4 ?? 0,
                    'assessment_5' => $animeRating->assessment_5 ?? 0,
                    'assessment_6' => $animeRating->assessment_6 ?? 0,
                    'assessment_7' => $animeRating->assessment_7 ?? 0,
                    'assessment_8' => $animeRating->assessment_8 ?? 0,
                    'assessment_9' => $animeRating->assessment_9 ?? 0,
                    'assessment_10' => $animeRating->assessment_10 ?? 0,
                    'count_assessments' => $animeRating->count_assessments ?? 0,
                    'rating' => $animeRating->rating ?? 0,
                ]);

            Anime::withoutTimestamps(function () use ($anime, $animeRating) {
                Anime::withoutEvents(function () use ($anime, $animeRating) {
                    $anime->count_assessments = $animeRating->count_assessments ?? 0;
                    $anime->rating = $animeRating->rating ?? 0;
                    $anime->update();
                });
            });
        }
        echo 'Рейтинг Аниме обновлён.'.PHP_EOL;

        foreach (Dorama::query()
            ->withoutGlobalScopes()
            ->select(['id', 'rating', 'count_assessments'])
            ->cursor() as $dorama) {

            $doramaRating = DoramaRating::query()->select(
                DB::raw('SUM((assessment = 1)::int) as assessment_1'),
                DB::raw('SUM((assessment = 2)::int) as assessment_2'),
                DB::raw('SUM((assessment = 3)::int) as assessment_3'),
                DB::raw('SUM((assessment = 4)::int) as assessment_4'),
                DB::raw('SUM((assessment = 5)::int) as assessment_5'),
                DB::raw('SUM((assessment = 6)::int) as assessment_6'),
                DB::raw('SUM((assessment = 7)::int) as assessment_7'),
                DB::raw('SUM((assessment = 8)::int) as assessment_8'),
                DB::raw('SUM((assessment = 9)::int) as assessment_9'),
                DB::raw('SUM((assessment = 10)::int) as assessment_10'),
                DB::raw('COUNT(*) as count_assessments'),
                DB::raw('ROUND(AVG(assessment), 2) as rating')
            )
                ->where('dorama_id', $dorama->id)
                ->groupBy('dorama_id')
                ->first();

            DoramaRatingStatistic::query()
                ->where('dorama_id', $dorama->id)
                ->first()->update([
                    'assessment_1' => $doramaRating->assessment_1 ?? 0,
                    'assessment_2' => $doramaRating->assessment_2 ?? 0,
                    'assessment_3' => $doramaRating->assessment_3 ?? 0,
                    'assessment_4' => $doramaRating->assessment_4 ?? 0,
                    'assessment_5' => $doramaRating->assessment_5 ?? 0,
                    'assessment_6' => $doramaRating->assessment_6 ?? 0,
                    'assessment_7' => $doramaRating->assessment_7 ?? 0,
                    'assessment_8' => $doramaRating->assessment_8 ?? 0,
                    'assessment_9' => $doramaRating->assessment_9 ?? 0,
                    'assessment_10' => $doramaRating->assessment_10 ?? 0,
                    'count_assessments' => $doramaRating->count_assessments ?? 0,
                    'rating' => $doramaRating->rating ?? 0,
                ]);

            Dorama::withoutTimestamps(function () use ($dorama, $doramaRating) {
                Dorama::withoutEvents(function () use ($dorama, $doramaRating) {
                    $dorama->count_assessments = $doramaRating->count_assessments ?? 0;
                    $dorama->rating = $doramaRating->rating ?? 0;
                    $dorama->update();
                });
            });
        }

        echo 'Рейтинг Дорам обновлён.'.PHP_EOL;

        cache()->store(CacheEnum::ANIMES_STORE->value)->forget(CacheEnum::MAIN_ANIMES->value);
        cache()->store(CacheEnum::DORAMAS_STORE->value)->forget(CacheEnum::MAIN_DORAMAS->value);

        echo 'Кэш Аниме и Дорам сброшен.'.PHP_EOL;

        $endTime = microtime(true);
        $endMemory = memory_get_peak_usage(true);

        $executionTime = round($endTime - $startTime, 2);
        $memoryUsage = round(($endMemory - $startMemory) / 1024 / 1024, 2);

        echo "Время выполнения: {$executionTime} seconds\n";
        echo "Памяти использовано: {$memoryUsage} MB\n";
    }
}
