<?php

use App\Http\Controllers\Api\AnimeController;
use App\Http\Controllers\Api\DoramaController;
use App\Http\Controllers\Api\Favorite\FavoriteAnimeController;
use App\Http\Controllers\Api\Favorite\FavoriteDoramaController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\Folders\FolderAnimesController;
use App\Http\Controllers\Api\Folders\FolderDoramasController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\Rating\AnimeRatingController;
use App\Http\Controllers\Api\Rating\DoramaRatingController;
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

        Route::middleware('auth')->group(function () {
            // Rating
            Route::post('/{id}/rating', [AnimeRatingController::class, 'store']);
            Route::patch('/{id}/rating', [AnimeRatingController::class, 'update']);
            Route::delete('/{id}/rating', [AnimeRatingController::class, 'destroy']);
            // Favorite
            Route::post('/favorite', [FavoriteAnimeController::class, 'show'])->withoutMiddleware('auth');
            Route::post('/{id}/favorite', [FavoriteAnimeController::class, 'store']);
            Route::patch('/{id}/favorite', [FavoriteAnimeController::class, 'update']);
            Route::delete('/{id}/favorite', [FavoriteAnimeController::class, 'destroy']);
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
            Route::get('/all-user-folders', [FolderAnimesController::class, 'allUserFolders']);
            Route::get('/only-user-folders', [FolderAnimesController::class, 'onlyUserFolders']);
            Route::get('/show', [FolderAnimesController::class, 'show']);
            Route::post('/', [FolderAnimesController::class, 'store']);
            Route::get('/{folder}/edit', [FolderAnimesController::class, 'edit']);
            Route::patch('/{folder}', [FolderAnimesController::class, 'update']);
            Route::delete('/{folder}', [FolderAnimesController::class, 'destroy']);
        });
        // Doramas
        Route::prefix('doramas')->group(function () {
            Route::get('/all-user-folders', [FolderDoramasController::class, 'allUserFolders']);
            Route::get('/only-user-folders', [FolderDoramasController::class, 'onlyUserFolders']);
            Route::get('/show', [FolderDoramasController::class, 'show']);
            Route::post('/', [FolderDoramasController::class, 'store']);
            Route::get('/{folder}/edit', [FolderDoramasController::class, 'edit']);
            Route::patch('/{folder}', [FolderDoramasController::class, 'update']);
            Route::delete('/{folder}', [FolderDoramasController::class, 'destroy']);
        });
    })->middleware(['auth']);
});
