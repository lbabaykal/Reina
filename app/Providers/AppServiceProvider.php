<?php

namespace App\Providers;

use App\Models\FolderAnime;
use App\Models\FolderDorama;
use App\Policies\Folders\FolderAnimePolicy;
use App\Policies\Folders\FolderDoramaPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        if(env('APP_ENV') == 'local')
        {
            url()->forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(FolderAnime::class, FolderAnimePolicy::class);
        Gate::policy(FolderDorama::class, FolderDoramaPolicy::class);

        Model::preventLazyLoading(! $this->app->isProduction());

        Relation::morphMap([
            'Anime' => 'App\Models\Anime',
            'Dorama' => 'App\Models\Dorama',
        ]);

        Paginator::defaultView('pagination');
    }
}
