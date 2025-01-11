<?php

use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'homepage'])->name('homepage');
Route::get('/categories', [PagesController::class, 'categories'])->name('categories');
Route::get('/categories/{category}', [PagesController::class, 'category'])->name('category');
Route::get('/product/{product}', [PagesController::class, 'product'])->name('product');
Route::get('/catalog', [PagesController::class, 'catalog'])->name('catalog');
Route::get('/checkout', [PagesController::class, 'checkout'])->name('checkout');
Route::get('/order-confirmation', [PagesController::class, 'orderConfirmation'])->name('orderConfirmation');

Route::get('/info/terms', [PagesController::class, 'termsAndConditions'])->name('infoTerms');
Route::get('/info/contact-us', [PagesController::class, 'contactUs'])->name('infoContactUs');

Route::get('/cart', [PagesController::class, 'cart'])->name('cart');
Route::post('/createOrder', [CartController::class, 'createOrder'])->name('createOrder');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('addToCart');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('removeFromCart');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cartUpdateRoute');

Route::post('/districts', [CartController::class, 'getDistrictsList'])->name('getDistrictsList');
