@extends('layouts.app')

@section('title', 'Confirmar Eliminación de Producto')

@section('content')
<div class="flex items-center justify-center max-h-screen bg-gray-100">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-red-50 px-4 py-2 border-b border-red-100">
                <h2 class="text-lg font-semibold text-red-700 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Confirmar Eliminación de Producto
                </h2>
            </div>
            <div class="px-4 py-3">
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-500">Código:</span>
                        <span class="font-semibold">{{ $product->code }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-500">Nombre:</span>
                        <span class="font-semibold">{{ $product->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-500">Categoría:</span>
                        <span>{{ $product->category }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-500">Sucursal:</span>
                        <span>{{ $product->branch }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-500">Cantidad:</span>
                        <span>{{ $product->quantity }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-500">Precio de Venta:</span>
                        <span>${{ number_format($product->sale_price, 2) }}</span>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right space-x-3">
                <a href="{{ route('products.index') }}" class="inline-block px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition duration-300">
                    Cancelar
                </a>
                <form action="{{ route('products.deactivate', $product->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition duration-300">
                        Confirmar Eliminación
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
