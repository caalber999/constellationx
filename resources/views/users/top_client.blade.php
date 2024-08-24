@extends('layouts.app')

@section('title', 'Clientes Top')

@section('content')
<div class="container">
    <h1>Clientes Top</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Total Gastado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topClients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>${{ number_format($client->total_spent, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
