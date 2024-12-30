<?php

namespace App\Console\Commands;

use App\Models\Anime;
use App\Models\Dorama;
use Illuminate\Console\Command;

class UpdateSlug extends Command
{
    protected $signature = 'update-slug';
    protected $description = 'Обновление слага.';

    public function handle(): void
    {
        $startTime = microtime(true);
        $startMemory = memory_get_peak_usage(true);

        foreach (Anime::query()
                     ->withoutGlobalScopes()
                     ->select(['id', 'slug', 'title_ru'])
                     ->cursor() as $anime) {
            $anime->generateSlug();
            $anime->timestamps = false;
            $anime->saveQuietly();
        }
        echo 'Слаг Аниме обновлён.' . PHP_EOL;

        foreach (Dorama::query()
                     ->withoutGlobalScopes()
                     ->select(['id', 'slug', 'title_ru'])
                     ->cursor() as $dorama) {
            $dorama->generateSlug();
            $dorama->timestamps = false;
            $dorama->saveQuietly();
        }
        echo 'Слаг Дорам обновлён.' . PHP_EOL;

        cache()->store('redis_animes')->forget('main_animes');
        cache()->store('redis_doramas')->forget('main_doramas');
        echo 'Кэш Аниме и Дорам сброшен.' . PHP_EOL;

        $endTime = microtime(true);
        $endMemory = memory_get_peak_usage(true);

        $executionTime = round($endTime - $startTime, 2);
        $memoryUsage = round(($endMemory - $startMemory) / 1024 / 1024, 2);

        echo "Время выполнения: {$executionTime} seconds\n";
        echo "Памяти использовано: {$memoryUsage} MB\n";
    }
}
