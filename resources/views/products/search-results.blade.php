@extends('layouts.app')

@section('title', 'Resultados de Búsqueda')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-5">
        Resultados de Búsqueda que contenga la palabra:
        @if(!empty($searchTerm))
        {{ $searchTerm }}
        @else
        (Todos los productos)
        @endif
    </h1>

    @if(isset($message))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ $message }}</span>
    </div>
    @endif

    @if(count($products) > 0)
    <table class="min-w-full bg-white text-center">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Código</th>
                <th class="py-2 px-4 border-b">Nombre</th>
                <th class="py-2 px-4 border-b">Categoría</th>
                <th class="py-2 px-4 border-b">Sucursal</th>
                <th class="py-2 px-4 border-b">Descripción</th>
                <th class="py-2 px-4 border-b">Cantidad</th>
                <th class="py-2 px-4 border-b">Precio de Venta</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td class="py-2 px-4 border-b">{{ $product->id }}</td>
                <td class="py-2 px-4 border-b">{{ $product->code }}</td>
                <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                <td class="py-2 px-4 border-b">{{ $product->category }}</td>
                <td class="py-2 px-4 border-b">{{ $product->branch }}</td>
                <td class="py-2 px-4 border-b">{{ $product->description }}</td>
                <td class="py-2 px-4 border-b">{{ $product->quantity }}</td>
                <td class="py-2 px-4 border-b">{{ $product->sale_price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="text-gray-700">No se encontraron productos que coincidan con los criterios de búsqueda.</p>
    @endif

    <div class="mt-4">
        <a href="{{ route('products.search') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Nueva Búsqueda
        </a>
        <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
            Volver al Listado
        </a>
    </div>
</div>
@endsection
