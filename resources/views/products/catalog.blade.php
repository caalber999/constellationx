@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Catálogo de Productos</h1>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text">Precio: ${{ number_format($product->price, 2) }}</p>
                        <a href="{{ route('purchases.create', $product) }}" class="btn btn-primary">Comprar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
