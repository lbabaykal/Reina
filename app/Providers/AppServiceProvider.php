<?php

namespace App\Providers;

use App\Models\Anime;
use App\Models\Dorama;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::preventLazyLoading(! $this->app->isProduction());

        Relation::morphMap([
            'anime' => Anime::class,
            'dorama' => Dorama::class,
        ]);

        Route::pattern('slug', '[a-zA-Z0-9_-]+');
        Route::pattern('id', '[0-9]+');
    }
}
