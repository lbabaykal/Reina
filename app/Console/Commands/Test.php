<?php

namespace App\Console\Commands;

use App\Models\Anime;
use App\Models\Dorama;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class Test extends Command
{
    protected $signature = 'test';
    protected $description = 'test command';

    public function handle(): void
    {
        $anime = Anime::query()->select(['id', 'slug'])
            ->where('slug', '11-inaia')
            ->firstOrFail();

        $anime->ratings()->updateOrCreate(
            ['user_id' => 1],
            ['assessment' => 1]
        );

        $dorama = Dorama::query()->select(['id', 'slug'])
            ->where('slug', '14-zashhiti-serdce-nazad-ot-kraia-propasti')
            ->firstOrFail();

        $dorama->ratings()->updateOrCreate(
            ['user_id' => 1],
            ['assessment' => 1]
        );

        echo "Command complete\n";
    }
}
