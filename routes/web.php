<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\DoramaController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Folder\FolderAnimesController;
use App\Http\Controllers\Folder\FolderDoramasController;
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
//    Route::get('/search', SearchController::class)->name('search');
    // ====SUBSCRIPTION====
//    Route::prefix('subscription')->name('subscription.')->group(function () {
//        Route::get('/', function () {
//            return 'Описание subscription';
//        })->name('index');
//    });

// ====ANIME====
//    Route::prefix('animes')->name('animes.')->group(function () {
//        Route::get('/{animes:slug}', [AnimeController::class, 'show'])->name('show');
//        Route::get('/{anime:slug}/watch', [AnimeController::class, 'watch'])->name('watch');
//        Route::get('/', [AnimeController::class, 'index'])->name('index');
//
//        Route::middleware('auth')->group(function () {
//            Route::patch('/{anime:slug}/rating', [RatingController::class, 'addToAnime'])->name('rating.add');
//            Route::delete('/{anime:slug}/rating', [RatingController::class, 'removeToAnime'])->name('rating.remove');
//            Route::patch('/{anime:slug}/favorite', [FavoriteController::class, 'addToAnime'])->name('favorite.add');
//            Route::delete('/{anime:slug}/favorite', [FavoriteController::class, 'removeToAnime'])->name('favorite.remove');
//        });
//    });

// ====DORAMA====
//    Route::prefix('dorama')
//        ->name('dorama.')
//        ->group(function () {
//            Route::get('/{dorama:slug}', [DoramaController::class, 'show'])->name('show');
//            Route::get('/{dorama:slug}/watch', [DoramaController::class, 'watch'])->name('watch');
//            Route::get('/', [DoramaController::class, 'index'])->name('index');
//
//            Route::middleware('auth')->group(function () {
//                Route::patch('/{dorama:slug}/rating', [RatingController::class, 'addToDorama'])->name('rating.add');
//                Route::delete('/{dorama:slug}/rating', [RatingController::class, 'removeToDorama'])->name('rating.remove');
//                Route::patch('/{dorama:slug}/favorite', [FavoriteController::class, 'addToDorama'])->name('favorite.add');
//                Route::delete('/{dorama:slug}/favorite', [FavoriteController::class, 'removeToDorama'])->name('favorite.remove');
//            });
//        });

    Route::middleware('auth')
        ->prefix('user')
        ->name('user.')
        ->group(function () {
            // ====FOLDERS====
//            Route::prefix('folders')->name('folders.')->group(function () {
//                Route::get('/', FolderController::class)->name('index');
//
//                Route::prefix('animes')->name('animes.')->group(function () {
//                    Route::get('/', [FolderAnimesController::class, 'index'])->name('index');
//                    Route::get('/{folder}', [FolderAnimesController::class, 'show'])->name('show');
//                    Route::get('/create', [FolderAnimesController::class, 'create'])->name('create');
//                    Route::post('/', [FolderAnimesController::class, 'store'])->name('store');
//                    Route::get('/{folder}/edit', [FolderAnimesController::class, 'edit'])->name('edit');
//                    Route::patch('/{folder}', [FolderAnimesController::class, 'update'])->name('update');
//                    Route::delete('/{folder}', [FolderAnimesController::class, 'destroy'])->name('destroy');
//                });
//
//                Route::prefix('doramas')->name('doramas.')->group(function () {
//                    Route::get('/', [FolderDoramasController::class, 'index'])->name('index');
//                    Route::get('/{folder}', [FolderDoramasController::class, 'show'])->name('show');
//                    Route::get('/create', [FolderDoramasController::class, 'create'])->name('create');
//                    Route::post('/', [FolderDoramasController::class, 'store'])->name('store');
//                    Route::get('/{folder}/edit', [FolderDoramasController::class, 'edit'])->name('edit');
//                    Route::patch('/{folder}', [FolderDoramasController::class, 'update'])->name('update');
//                    Route::delete('/{folder}', [FolderDoramasController::class, 'destroy'])->name('destroy');
//                });
//            });

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


