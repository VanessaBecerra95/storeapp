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

//Actualizar producto
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

//Eliminar de forma lógica
Route::get('/products/{id}/confirm-delete', [ProductController::class, 'confirmDelete'])->name('products.confirm-delete');
Route::put('/products/{id}/deactivate', [ProductController::class, 'deactivate'])->name('products.deactivate');
