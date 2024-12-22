<?php

use App\Http\Controllers\Store\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'homepage']);
Route::get('/categories', [PagesController::class, 'categories']);
Route::get('/category/{category}', [PagesController::class, 'category']);
Route::get('/product/{product}', [PagesController::class, 'product'])->name('product');
