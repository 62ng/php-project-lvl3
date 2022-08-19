<?php

use App\Http\Controllers\FormController;
use http\Client\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FormController::class, 'form'])->name('form');

Route::post('/', [FormController::class, 'store'])->name('form_post');

Route::get('/urls', [FormController::class, 'urls.index'])->name('urls');

Route::get('/urls/{id}', [FormController::class, 'show'])->name('url_page');
