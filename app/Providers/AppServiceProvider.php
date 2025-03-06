<?php

namespace App\Providers;

use App\Models\AnimeFolder;
use App\Models\DoramaFolder;
use App\Models\FavoriteAnime;
use App\Models\FavoriteDorama;
use App\Policies\Favorite\FavoriteAnimePolicy;
use App\Policies\Favorite\FavoriteDoramaPolicy;
use App\Policies\Folders\AnimeFolderPolicy;
use App\Policies\Folders\DoramaFolderPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (env('APP_ENV') == 'local') {
            url()->forceScheme('https');
        }
    }

    public function boot(): void
    {
        Gate::policy(AnimeFolder::class, AnimeFolderPolicy::class);
        Gate::policy(DoramaFolder::class, DoramaFolderPolicy::class);

        Model::preventLazyLoading(! $this->app->isProduction());

        Relation::morphMap([
            'Anime' => 'App\Models\Anime',
            'Dorama' => 'App\Models\Dorama',
        ]);

        Paginator::defaultView('pagination');
    }
}
