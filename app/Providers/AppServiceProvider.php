<?php

namespace App\Providers;

use App\Models\AnimeFolder;
use App\Models\DoramaFolder;
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
        //
    }

    public function boot(): void
    {
        Gate::policy(AnimeFolder::class, AnimeFolderPolicy::class);
        Gate::policy(DoramaFolder::class, DoramaFolderPolicy::class);

        Model::preventLazyLoading(! $this->app->isProduction());

        Relation::morphMap([
            'anime' => 'App\Models\Anime',
            'dorama' => 'App\Models\Dorama',
            'manga' => 'App\Models\Manga',
        ]);

        Paginator::defaultView('pagination');
    }
}
