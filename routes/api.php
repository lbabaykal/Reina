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

        Route::get('/folders', [AnimeFolderController::class, 'folders']);
        Route::get('/{slug}', [AnimeController::class, 'show']);
        Route::get('/{slug}/watch', [AnimeController::class, 'watch']);
        Route::get('/{slug}/relations', [AnimeController::class, 'relations']);
        Route::get('/{slug}/episodes', [AnimeController::class, 'episodes']);
        Route::get('/{slug}/characters', [AnimeController::class, 'characters']);
        Route::get('/{slug}/staff', [AnimeController::class, 'staff']);

        Route::middleware(['auth', 'throttle:50,1'])->group(function () {
            // Rating
            Route::get('/{slug}/rating', [AnimeRatingController::class, 'show'])->withoutMiddleware('auth');
            Route::post('/rating', [AnimeRatingController::class, 'store']);
            Route::delete('/{slug}/rating', [AnimeRatingController::class, 'destroy']);
            // Favorite
            Route::get('/{slug}/favorite', [FavoriteAnimeController::class, 'show'])->withoutMiddleware('auth');
            Route::post('/favorite', [FavoriteAnimeController::class, 'store']);
            Route::delete('/favorite/{id}', [FavoriteAnimeController::class, 'destroy']);
        });
    });

    Route::prefix('doramas')->name('doramas.')->group(function () {
        Route::get('/', [DoramaController::class, 'index']);

        Route::get('/folders', [DoramaFolderController::class, 'folders']);
        Route::get('/{slug}', [DoramaController::class, 'show']);
        Route::get('/{slug}/watch', [DoramaController::class, 'watch']);
        Route::get('/{slug}/relations', [DoramaController::class, 'relations']);
        Route::get('/{slug}/episodes', [DoramaController::class, 'episodes']);
        Route::get('/{slug}/staff', [DoramaController::class, 'staff']);

        Route::middleware(['auth', 'throttle:50,1'])->group(function () {
            // Rating
            Route::get('/{slug}/rating', [DoramaRatingController::class, 'show'])->withoutMiddleware('auth');
            Route::post('/rating', [DoramaRatingController::class, 'store']);
            Route::delete('/{slug}/rating', [DoramaRatingController::class, 'destroy']);
            // Favorite
            Route::get('/{slug}/favorite', [FavoriteDoramaController::class, 'show'])->withoutMiddleware('auth');
            Route::post('/favorite', [FavoriteDoramaController::class, 'store']);
            Route::delete('/favorite/{id}', [FavoriteDoramaController::class, 'destroy']);
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
