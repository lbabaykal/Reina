<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\DoramaController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Folder\AnimeFolderController;
use App\Http\Controllers\Folder\DoramaFolderController;
use App\Http\Controllers\Folder\FolderController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::pattern('slug', '[a-zA-Z0-9_-]+');

Route::domain(env('APP_URL'))->get('/{page?}', function() {
    return view('app');
})->where('page', '.*')->name('index');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';

//============================================
Route::domain(env('APP_URL'))->group(function () {
    Route::get('/', MainController::class)->name('main');

    // ====SEARCH====
    Route::get('/search', SearchController::class)->name('search');
    // ====SUBSCRIPTION====
    Route::prefix('subscription')->name('subscription.')->group(function () {
        Route::get('/', function () {
            return 'Описание subscription';
        })->name('index');
    });

// ====ANIME====
    Route::prefix('anime')->name('anime.')->group(function () {
        Route::get('/{anime:slug}', [AnimeController::class, 'show'])->name('show');
//        Route::get('/{anime}-{slug}', [AnimeController::class, 'show'])->name('show');
        Route::get('/{anime:slug}/watch', [AnimeController::class, 'watch'])->name('watch');
        Route::get('/', [AnimeController::class, 'index'])->name('index');

        Route::middleware('auth')->group(function () {
            Route::patch('/{anime:slug}/rating', [RatingController::class, 'addToAnime'])->name('rating.add');
            Route::delete('/{anime:slug}/rating', [RatingController::class, 'removeToAnime'])->name('rating.remove');
            Route::patch('/{anime:slug}/favorite', [FavoriteController::class, 'addToAnime'])->name('favorite.add');
            Route::delete('/{anime:slug}/favorite', [FavoriteController::class, 'removeToAnime'])->name('favorite.remove');
        });
    });

// ====DORAMA====
    Route::prefix('dorama')
        ->name('dorama.')
        ->group(function () {
            Route::get('/{dorama:slug}', [DoramaController::class, 'show'])->name('show');
            Route::get('/{dorama:slug}/watch', [DoramaController::class, 'watch'])->name('watch');
            Route::get('/', [DoramaController::class, 'index'])->name('index');

            Route::middleware('auth')->group(function () {
                Route::patch('/{dorama:slug}/rating', [RatingController::class, 'addToDorama'])->name('rating.add');
                Route::delete('/{dorama:slug}/rating', [RatingController::class, 'removeToDorama'])->name('rating.remove');
                Route::patch('/{dorama:slug}/favorite', [FavoriteController::class, 'addToDorama'])->name('favorite.add');
                Route::delete('/{dorama:slug}/favorite', [FavoriteController::class, 'removeToDorama'])->name('favorite.remove');
            });
        });

    Route::middleware('auth')
        ->prefix('user')
        ->name('user.')
        ->group(function () {
            // ====FOLDERS====
            Route::prefix('folders')->name('folders.')->group(function () {
                Route::get('/', FolderController::class)->name('index');

                Route::prefix('animes')->name('animes.')->group(function () {
                    Route::get('/', [AnimeFolderController::class, 'index'])->name('index');
                    Route::get('/{folder}', [AnimeFolderController::class, 'show'])->name('show');
                    Route::get('/create', [AnimeFolderController::class, 'create'])->name('create');
                    Route::post('/', [AnimeFolderController::class, 'store'])->name('store');
                    Route::get('/{folder}/edit', [AnimeFolderController::class, 'edit'])->name('edit');
                    Route::patch('/{folder}', [AnimeFolderController::class, 'update'])->name('update');
                    Route::delete('/{folder}', [AnimeFolderController::class, 'destroy'])->name('destroy');
                });

                Route::prefix('doramas')->name('doramas.')->group(function () {
                    Route::get('/', [DoramaFolderController::class, 'index'])->name('index');
                    Route::get('/{folder}', [DoramaFolderController::class, 'show'])->name('show');
                    Route::get('/create', [DoramaFolderController::class, 'create'])->name('create');
                    Route::post('/', [DoramaFolderController::class, 'store'])->name('store');
                    Route::get('/{folder}/edit', [DoramaFolderController::class, 'edit'])->name('edit');
                    Route::patch('/{folder}', [DoramaFolderController::class, 'update'])->name('update');
                    Route::delete('/{folder}', [DoramaFolderController::class, 'destroy'])->name('destroy');
                });
            });

            // Profile
            Route::middleware(['auth', 'verified'])
                ->prefix('profile')
                ->name('profile.')
                ->group(function () {
                    Route::get('/', [ProfileController::class, 'edit'])->name('index');
                    Route::patch('/', [ProfileController::class, 'update'])->name('update');
                    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
                });
        });
});


