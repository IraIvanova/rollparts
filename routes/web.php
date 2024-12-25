<?php

use App\Http\Controllers\Store\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'homepage'])->name('homepage');
Route::get('/categories', [PagesController::class, 'categories'])->name('categories');
Route::get('/categories/{category}', [PagesController::class, 'category'])->name('category');
Route::get('/product/{product}', [PagesController::class, 'product'])->name('product');
