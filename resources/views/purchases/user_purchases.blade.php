@extends('layouts.app')

@section('title', 'Compras de {{ $user->name }}')

@section('content')
<div class="container">
    <h1>Compras de {{ $user->name }}</h1>

    <!-- Mostrar las compras -->
    @if($purchases->isEmpty())
        <p>No hay compras registradas para este usuario.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->id }}</td>
                        <td>{{ $purchase->product->name }}</td>
                        <td>{{ 1 }}</td>
                        <td>${{ number_format($purchase->amount, 2) }}</td>
                        <td>${{ number_format($purchase->amount, 2) }}</td>
                        <td>{{ $purchase->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
