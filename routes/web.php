<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('admin.index');
})->name('admin_index');


Route::get('/sliders', [SliderController::class, 'index'])->name('slider_index');
Route::get('/sliders/create', [SliderController::class, 'create'])->name('slider_create');
Route::post('/sliders', [SliderController::class, 'store'])->name('slider_store');
Route::get('/sliders/{slider}/edit', [SliderController::class, 'edit'])->name('slider_edit');
Route::put('/sliders/{slider}', [SliderController::class, 'update'])->name('slider_update');
Route::delete('/sliders/{slider}/delete', [SliderController::class, 'destroy'])->name('slider_destroy');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories_index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories_create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories_store');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories_edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories_update');
Route::delete('/categories/{category}/delete', [CategoryController::class, 'destroy'])->name('categories_destroy');

Route::get('/products', [ProductController::class, 'index'])->name('products_index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products_create');
Route::post('/products', [ProductController::class, 'store'])->name('products_store');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products_edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products_update');
Route::delete('/products/{product}/delete', [ProductController::class, 'destroy'])->name('products_destroy');