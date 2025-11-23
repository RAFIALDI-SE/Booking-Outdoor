<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;

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