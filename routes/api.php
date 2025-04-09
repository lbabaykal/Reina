<?php

use App\Http\Controllers\Api\AnimeController;
use App\Http\Controllers\Api\DoramaController;
use App\Http\Controllers\Api\Anime\FavoriteAnimeController;
use App\Http\Controllers\Api\Dorama\FavoriteDoramaController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\Anime\AnimeFolderController;
use App\Http\Controllers\Api\Dorama\DoramaFolderController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\Anime\AnimeRatingController;
use App\Http\Controllers\Api\Dorama\DoramaRatingController;
use App\Http\Controllers\Api\SearchController;
use Illuminate\Support\Facades\Route;

Route::domain(env('APP_URL'))->group(function () {
    Route::get('/user-data', function () {
        $authCheck = auth()->check();

        if ($authCheck) {
            return response()->json([
                'authenticated' => $authCheck,
                'user' => new \App\Http\Resources\UserLoginResource(auth()->user()),
            ]);
        } else {
            return response()->json([
                'authenticated' => $authCheck,
            ]);
        }
    });

    Route::get('/main', MainController::class)->name('main');
    Route::get('/search', [SearchController::class, 'index']);
    Route::get('/search-data', [SearchController::class, 'searchData']);

    Route::prefix('animes')->name('animes.')->group(function () {
        Route::get('/', [AnimeController::class, 'index']);

        Route::get('/{slug}', [AnimeController::class, 'show']);
        Route::get('/{slug}/watch', [AnimeController::class, 'watch']);

        Route::middleware(['auth', 'throttle:20,1'])->group(function () {
            // Rating
            Route::post('/{id}/rating', [AnimeRatingController::class, 'store']);
            Route::patch('/{id}/rating', [AnimeRatingController::class, 'update']);
            Route::delete('/{id}/rating', [AnimeRatingController::class, 'destroy']);
            // Favorite
            Route::post('/favorite', [FavoriteAnimeController::class, 'show'])->withoutMiddleware('auth');
            Route::post('/{id}/favorite', [FavoriteAnimeController::class, 'store']);
            Route::patch('/{id}/favorite', [FavoriteAnimeController::class, 'update']);
            Route::delete('/{id}/favorite', [FavoriteAnimeController::class, 'destroy']);
            // Favorite Episode
            Route::post('/{id}/remember-episode', [FavoriteAnimeController::class, 'rememberEpisode']);
            Route::delete('/{id}/forget-episode', [FavoriteAnimeController::class, 'forgetEpisode']);
        });
    });

    Route::prefix('doramas')->name('doramas.')->group(function () {
        Route::get('/', [DoramaController::class, 'index']);

        Route::get('/{slug}', [DoramaController::class, 'show']);
        Route::get('/{slug}/watch', [DoramaController::class, 'watch']);

        Route::middleware('auth')->group(function () {
            // Rating
            Route::post('/{id}/rating', [DoramaRatingController::class, 'store']);
            Route::patch('/{id}/rating', [DoramaRatingController::class, 'update']);
            Route::delete('/{id}/rating', [DoramaRatingController::class, 'destroy']);
            // Favorite
            Route::post('/favorite', [FavoriteDoramaController::class, 'show'])->withoutMiddleware('auth');
            Route::post('/{id}/favorite', [FavoriteDoramaController::class, 'store']);
            Route::patch('/{id}/favorite', [FavoriteDoramaController::class, 'update']);
            Route::delete('/{id}/favorite', [FavoriteDoramaController::class, 'destroy']);
            // Favorite Episode
            Route::post('/{id}/remember-episode', [FavoriteDoramaController::class, 'rememberEpisode']);
            Route::delete('/{id}/forget-episode', [FavoriteDoramaController::class, 'forgetEpisode']);
        });
    });

    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::get('/', [FavoriteController::class, 'index']);
        Route::get('/{id}', [FavoriteController::class, 'show']);
    });

    // Folders
    Route::prefix('folders')->group(function () {
        // Animes
        Route::prefix('animes')->group(function () {
            Route::get('/all-user-folders', [AnimeFolderController::class, 'allUserFolders']);
            Route::get('/only-user-folders', [AnimeFolderController::class, 'onlyUserFolders']);
            Route::get('/show', [AnimeFolderController::class, 'show']);
            Route::post('/', [AnimeFolderController::class, 'store']);
            Route::get('/{folder}/edit', [AnimeFolderController::class, 'edit']);
            Route::patch('/{folder}', [AnimeFolderController::class, 'update']);
            Route::delete('/{folder}', [AnimeFolderController::class, 'destroy']);
        });
        // Doramas
        Route::prefix('doramas')->group(function () {
            Route::get('/all-user-folders', [DoramaFolderController::class, 'allUserFolders']);
            Route::get('/only-user-folders', [DoramaFolderController::class, 'onlyUserFolders']);
            Route::get('/show', [DoramaFolderController::class, 'show']);
            Route::post('/', [DoramaFolderController::class, 'store']);
            Route::get('/{folder}/edit', [DoramaFolderController::class, 'edit']);
            Route::patch('/{folder}', [DoramaFolderController::class, 'update']);
            Route::delete('/{folder}', [DoramaFolderController::class, 'destroy']);
        });
    })->middleware(['auth']);
});
