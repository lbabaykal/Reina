<?php

namespace App\Console\Commands;

use App\Models\Anime;
use App\Models\AnimeEpisode;
use App\Models\Dorama;
use App\Models\DoramaEpisode;
use App\Models\Franchise;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Test extends Command
{
    protected $signature = 'test';

    protected $description = 'test command';

    public function handle(): void
    {
        $startTime = microtime(true);

//        $franchise = Franchise::query()->create([
//            'title_ru' => 'Наруто',
//            'title_en' => 'Naruto',
//        ]);

//        $franchise = Franchise::query()->find(1);

//        $anime1 = Anime::query()->find(11);
//        $anime2 = Anime::query()->find(6);
//        $dorama = Dorama::query()->find(14);

//        $franchise->animes()->save($anime1);
//        $franchise->animes()->save($anime2);

//        $franchise->doramas()->save($dorama);

//        Franchise::query()->find(1)->delete();



        $endTime = microtime(true);
        $executionTime = round($endTime - $startTime, 2);
        echo "Время выполнения: {$executionTime} seconds\n";
        echo "Test - Command complete\n";
    }
}
