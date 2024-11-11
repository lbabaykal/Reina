<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Dorama;
use App\Reina;
use Illuminate\View\View;

class MainController extends Controller
{
    public function __invoke(): View
    {
        $animes = cache()->store('redis_animes')->remember('main_animes', 14400, function () {
            return Anime::query()
                ->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total'])
                ->limit(Reina::COUNT_ARTICLES_MAIN)
                ->latest('updated_at')
                ->get();
        });

        $doramas = cache()->store('redis_doramas')->remember('main_doramas', 14400, function () {
            return Dorama::query()
                ->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total'])
                ->limit(Reina::COUNT_ARTICLES_MAIN)
                ->latest('updated_at')
                ->get();
        });

        return view('layouts.main')
            ->with('animes', $animes)
            ->with('doramas', $doramas);
    }
}
