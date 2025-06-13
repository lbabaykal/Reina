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

/*        Schema::create('anime_rating_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Anime::class)->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('assessment_1')->default(0);
            $table->unsignedBigInteger('assessment_2')->default(0);
            $table->unsignedBigInteger('assessment_3')->default(0);
            $table->unsignedBigInteger('assessment_4')->default(0);
            $table->unsignedBigInteger('assessment_5')->default(0);
            $table->unsignedBigInteger('assessment_6')->default(0);
            $table->unsignedBigInteger('assessment_7')->default(0);
            $table->unsignedBigInteger('assessment_8')->default(0);
            $table->unsignedBigInteger('assessment_9')->default(0);
            $table->unsignedBigInteger('assessment_10')->default(0);
            $table->unsignedBigInteger('count_assessments')->default(0);
            $table->float('rating', 2)->default(0);
            $table->timestamps();
        });

        Schema::create('dorama_rating_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Dorama::class)->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('assessment_1')->default(0);
            $table->unsignedBigInteger('assessment_2')->default(0);
            $table->unsignedBigInteger('assessment_3')->default(0);
            $table->unsignedBigInteger('assessment_4')->default(0);
            $table->unsignedBigInteger('assessment_5')->default(0);
            $table->unsignedBigInteger('assessment_6')->default(0);
            $table->unsignedBigInteger('assessment_7')->default(0);
            $table->unsignedBigInteger('assessment_8')->default(0);
            $table->unsignedBigInteger('assessment_9')->default(0);
            $table->unsignedBigInteger('assessment_10')->default(0);
            $table->unsignedBigInteger('count_assessments')->default(0);
            $table->float('rating', 2)->default(0);
            $table->timestamps();
        });*/


        $endTime = microtime(true);
        $executionTime = round($endTime - $startTime, 2);
        echo "Время выполнения: {$executionTime} seconds\n";
        echo "Test - Command complete\n";
    }
}
