<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::pattern('slug', '[a-zA-Z0-9_-]+');

Route::domain(env('APP_URL'))->get('/{page?}', function() {
    return view('app');
})->where('page', '.*')->name('index');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';

//============================================
Route::domain(env('APP_URL'))->group(function () {
    Route::get('/')->name('main');

// ====ANIME====
    Route::prefix('animes')->name('animes.')->group(function () {
        Route::get('/{animes:slug}')->name('show');
        Route::get('/{anime:slug}/watch')->name('watch');
        Route::get('/')->name('index');
            });

// ====DORAMA====
    Route::prefix('dorama')
        ->name('dorama.')
        ->group(function () {
            Route::get('/{dorama:slug}')->name('show');
            Route::get('/{dorama:slug}/watch')->name('watch');
            Route::get('/')->name('index');
        });

    Route::middleware('auth')
        ->prefix('user')
        ->name('user.')
        ->group(function () {
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


