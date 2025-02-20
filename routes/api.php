<?php

use App\Http\Controllers\Api\AnimeController;
use App\Http\Controllers\Api\DoramaController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\Folders\FolderAnimesController;
use App\Http\Controllers\Api\Folders\FolderDoramasController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\RatingController;
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

        // Rating
        Route::post('/{id}/rating', [RatingController::class, 'addForAnime']);
        Route::delete('/{id}/rating', [RatingController::class, 'removeForAnime']);

        // Favorite
        Route::post('/favorite', [FavoriteController::class, 'getForAnime']);
        Route::post('/{id}/favorite', [FavoriteController::class, 'addForAnime']);
        Route::delete('/{id}/favorite', [FavoriteController::class, 'removeForAnime']);
    });

    Route::prefix('doramas')->name('doramas.')->group(function () {
        Route::get('/', [DoramaController::class, 'index']);

        Route::get('/{slug}', [DoramaController::class, 'show']);
        Route::get('/{slug}/watch', [DoramaController::class, 'watch']);

        // Rating
        Route::post('/{id}/rating', [RatingController::class, 'addForDorama']);
        Route::delete('/{id}/rating', [RatingController::class, 'removeForDorama']);

        // Favorite
        Route::post('/favorite', [FavoriteController::class, 'getForDorama']);
        Route::post('/{id}/favorite', [FavoriteController::class, 'addForDorama']);
        Route::delete('/{id}/favorite', [FavoriteController::class, 'removeForDorama']);
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

