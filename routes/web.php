<?php

use App\Http\Controllers\CheckController;
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'form')->name('form');

Route::resource('urls', UrlController::class);

Route::post('/urls/{id}/checks', [CheckController::class, 'store'])->name('check_url');
