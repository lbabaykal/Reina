<?php

use App\Http\Controllers\AdminPanel\AdminPanelController;
use App\Http\Controllers\AdminPanel\AnimeAdminController;
use App\Http\Controllers\AdminPanel\AnimeEpisodesAdminController;
use App\Http\Controllers\AdminPanel\CountriesAdminController;
use App\Http\Controllers\AdminPanel\DoramaAdminController;
use App\Http\Controllers\AdminPanel\DoramaEpisodesAdminController;
use App\Http\Controllers\AdminPanel\GenreAdminController;
use App\Http\Controllers\AdminPanel\StudiosAdminController;
use App\Http\Controllers\AdminPanel\TypeAdminController;
use Illuminate\Support\Facades\Route;

Route::domain('admin.'.env('APP_URL'))
    ->middleware('auth')
    ->name('admin.')
    ->group(function () {
        Route::get('/', AdminPanelController::class)->name('index');

        Route::prefix('animes')->name('animes.')->group(function () {
            Route::get('/', [AnimeAdminController::class, 'index'])->name('index');
            Route::get('/create', [AnimeAdminController::class, 'create'])->name('create');
            Route::post('/', [AnimeAdminController::class, 'store'])->name('store');
            Route::get('/{slug}/edit', [AnimeAdminController::class, 'edit'])->name('edit');
            Route::patch('/{slug}', [AnimeAdminController::class, 'update'])->name('update');

            Route::get('/draft', [AnimeAdminController::class, 'draft'])->name('draft');
            Route::get('/published', [AnimeAdminController::class, 'published'])->name('published');
            Route::get('/archive', [AnimeAdminController::class, 'archive'])->name('archive');
            Route::get('/deleted', [AnimeAdminController::class, 'deleted'])->name('deleted');
            Route::get('/{slug}/restore', [AnimeAdminController::class, 'restore'])->name('restore');

            Route::prefix('{anime}')->group(function () {
                Route::resource('episodes', AnimeEpisodesAdminController::class)->except(['show']);
            });
        });

        Route::prefix('doramas')->name('doramas.')->group(function () {
            Route::get('/', [DoramaAdminController::class, 'index'])->name('index');
            Route::get('/create', [DoramaAdminController::class, 'create'])->name('create');
            Route::post('/', [DoramaAdminController::class, 'store'])->name('store');
            Route::get('/{slug}/edit', [DoramaAdminController::class, 'edit'])->name('edit');
            Route::patch('/{slug}', [DoramaAdminController::class, 'update'])->name('update');

            Route::get('/draft', [DoramaAdminController::class, 'draft'])->name('draft');
            Route::get('/published', [DoramaAdminController::class, 'published'])->name('published');
            Route::get('/archive', [DoramaAdminController::class, 'archive'])->name('archive');
            Route::get('/deleted', [DoramaAdminController::class, 'deleted'])->name('deleted');
            Route::get('/{slug}/restore', [DoramaAdminController::class, 'restore'])->name('restore');

            Route::prefix('{dorama}')->group(function () {
                Route::resource('episodes', DoramaEpisodesAdminController::class)->except(['show']);
            });
        });

        Route::resource('/types', TypeAdminController::class)->except(['show', 'destroy']);
        Route::resource('/genres', GenreAdminController::class)->except(['show', 'destroy']);
        Route::resource('/studios', StudiosAdminController::class)->except(['show', 'destroy']);
        Route::resource('/countries', CountriesAdminController::class)->except(['show', 'destroy']);
    });
