<?php

use App\Http\Controllers\Api\AnimeController;
use App\Http\Controllers\Api\DoramaController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\SearchController;
use Illuminate\Http\Request;
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
    Route::get('/search-data', SearchController::class);


    Route::prefix('animes')->name('animes.')->group(function () {
        Route::get('/', [AnimeController::class, 'index'])->name('index');

        Route::get('/{animes:slug}', [AnimeController::class, 'show'])->name('show');
        Route::get('/{animes:slug}/watch', [AnimeController::class, 'watch'])->name('watch');

//        Route::middleware('auth')->group(function () {
//            Route::patch('/{anime:slug}/rating', [RatingController::class, 'addToAnime'])->name('rating.add');
//            Route::delete('/{anime:slug}/rating', [RatingController::class, 'removeToAnime'])->name('rating.remove');
//            Route::patch('/{anime:slug}/favorite', [FavoriteController::class, 'addToAnime'])->name('favorite.add');
//            Route::delete('/{anime:slug}/favorite', [FavoriteController::class, 'removeToAnime'])->name('favorite.remove');
//        });
    });

    Route::prefix('doramas')->name('doramas.')->group(function () {
        Route::get('/', [DoramaController::class, 'index'])->name('index');

        Route::get('/{slug}', [DoramaController::class, 'show'])->name('show');
    });
});

