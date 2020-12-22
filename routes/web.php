<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('test', 'test');
Route::view('app', 'layouts.app');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resources([
        'invoices' => InvoiceController::class,
        'sections' => SectionController::class,
        'products' => ProductController::class,
    ]);
});

Route::get('section/{id}', [InvoiceController::class, 'getProducts']);

Route::get('{page}', [AdminController::class, 'index']);
