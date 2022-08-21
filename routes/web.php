<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\UrlController;
use http\Client\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [FormController::class, 'form'])->name('form');

Route::post('/', [FormController::class, 'store'])->name('form_post');

Route::resource('urls', UrlController::class);
