<?php

use App\Http\Controllers\CheckController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FormController::class, 'form'])->name('form');

Route::post('/', [FormController::class, 'store'])->name('form_post');

Route::resource('urls', UrlController::class);

Route::post('/urls/{id}/checks', [CheckController::class, 'store'])->name('check_post');
