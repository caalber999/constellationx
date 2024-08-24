@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Listado de Ingresos/Compras</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Comprador</th>
                <th>Cantidad</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->product->name }}</td>
                    <td>{{ $purchase->user->name }}</td>
                    <td>${{ number_format($purchase->amount, 2) }}</td>
                    <td>{{ $purchase->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
