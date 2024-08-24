@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<div class="container">
    <h1 class="my-4">Crear Producto</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Producto</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagen del Producto</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Producto</button>
    </form>
</div>
@endsection
