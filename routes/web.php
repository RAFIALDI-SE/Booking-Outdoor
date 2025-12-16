<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReturnController;

Route::get('/', [OnboardingController::class, 'index'])->name('onboarding');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginStore'])->name('loginStore');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerStore'])->name('registerStore');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/products/all', [ProductController::class, 'all_products'])->name('products_all');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile_edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile_update');
Route::get('/products/{id}/detail', [ProductController::class, 'show'])->name('products_detail');

Route::get('/cart', [CartController::class, 'index'])->name('cart_index');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart_update');
Route::post('/cart/rent-days', [CartController::class, 'updateDays'])->name('cart_updateDays');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart_add');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart_delete');
    
Route::post('/repay/{code}', [BookingController::class, 'repay'])->name('repay');
Route::get('/payment/history', [BookingController::class, 'history'])->name('history_payment');
Route::get('/payment/history/{code}', [BookingController::class, 'historyDetail'])->name('history_payment_detail');

Route::post('/checkout/store', [BookingController::class, 'checkoutStore'])->name('checkoutStore');

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

Route::get('/contents', [ContentController::class, 'index'])->name('contents_index');
Route::get('/contents/create', [ContentController::class, 'create'])->name('contents_create');
Route::post('/contents', [ContentController::class, 'store'])->name('contents_store');
Route::get('/contents/{content}/edit', [ContentController::class, 'edit'])->name('contents_edit');
Route::put('/contents/{content}', [ContentController::class, 'update'])->name('contents_update');
Route::delete('/contents/{content}/delete', [ContentController::class, 'destroy'])->name('contents_destroy');

Route::get('/transaction', [TransactionController::class, 'index'])->name('admin_transation_index');
Route::get('/transaction/{code}', [TransactionController::class, 'show'])->name('admin_transation_show');

Route::get('/return/index', [ReturnController::class, 'index'])->name('returns_index');
Route::get('/check/{code}', [ReturnController::class, 'checkItems'])->name('returns_check_items');
Route::post('/process/{code}', [ReturnController::class, 'processCheck'])->name('returns_process_check');
Route::get('/fine', [ReturnController::class, 'inputFine'])->name('returns_input_fine');
Route::post('/finalize-fine', [ReturnController::class, 'finalizeFine'])->name('returns_finalize_fine');
Route::get('/report/{code}', [ReturnController::class, 'report'])->name('returns_report');