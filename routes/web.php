<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Listado de productos
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Crear producto
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Mostrar el formulario de búsqueda
Route::get('/products/search', [ProductController::class, 'searchForm'])->name('products.search');

// Procesar la búsqueda
Route::post('/products/search', [ProductController::class, 'searchResults'])->name('products.search.results');
