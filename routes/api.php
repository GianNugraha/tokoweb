<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ProductController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::controller(ProductController::class)->group(function () {
    Route::get('product/list', 'index');
    Route::post('product/create', 'store');
    Route::get('product/{id}', 'show');
    Route::patch('product/{id}', 'update');
    Route::delete('product/{id}', 'destroy');
});

Route::controller(CategoryProductController::class)->group(function () {
    Route::get('category/list', 'index');
    Route::post('category/create', 'store');
    Route::get('category/{id}', 'show');
    Route::put('category/{id}', 'update');
    Route::delete('category/{id}', 'destroy');
});
