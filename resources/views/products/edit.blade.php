@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Producto</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Producto</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagen del Producto</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($product->image)
                <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width: 100px;" class="mt-3">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Producto</button>
    </form>
</div>
@endsection
