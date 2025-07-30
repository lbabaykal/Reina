<?php

use Illuminate\Support\Facades\Route;

Route::domain(env('APP_URL'))->get('/{page?}', function () {
    return view('app');
})->where('page', '.*')->name('index');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
