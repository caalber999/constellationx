@extends('layouts.app')

@section('title', 'Gráficos Estadísticos')

@section('content')
<div class="container">
    <h1>Gráficos Estadísticos</h1>
    <div class="row">
        <!-- Gráfico de Productos Más Vendidos -->
        <div class="col-md-6">
            <h2>Productos Más Vendidos</h2>
            <canvas id="topProductsChart"></canvas>
        </div>
        <!-- Gráfico de Productos Menos Comprados -->
        <div class="col-md-6">
            <h2>Productos Menos Comprados</h2>
            <canvas id="bottomProductsChart"></canvas>
        </div>
        <!-- Gráfico de Ingresos por Día -->
        <div class="col-md-6">
            <h2>Ingresos por Día</h2>
            <canvas id="dailyRevenueChart"></canvas>
        </div>
        <!-- Gráfico de Ingresos por Semana -->
        <div class="col-md-6">
            <h2>Ingresos por Semana</h2>
            <canvas id="weeklyRevenueChart"></canvas>
        </div>
        <!-- Gráfico de Ingresos por Mes -->
        <div class="col-md-12">
            <h2>Ingresos por Mes</h2>
            <canvas id="monthlyRevenueChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('topProductsChart').getContext('2d');
    var topProductsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($topProducts->pluck('name')),
            datasets: [{
                label: 'Cantidad Vendida',
                data: @json($topProducts->pluck('count')),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx = document.getElementById('bottomProductsChart').getContext('2d');
    var bottomProductsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($bottomProducts->pluck('name')),
            datasets: [{
                label: 'Cantidad Comprada',
                data: @json($bottomProducts->pluck('count')),
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx = document.getElementById('dailyRevenueChart').getContext('2d');
    var dailyRevenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($dailyRevenue->pluck('date')),
            datasets: [{
                label: 'Ingresos Diarios',
                data: @json($dailyRevenue->pluck('total')),
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx = document.getElementById('weeklyRevenueChart').getContext('2d');
    var weeklyRevenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($weeklyRevenue->map(function($item) {
                return 'Semana ' . $item->week . ' ' . $item->year;
            })),
            datasets: [{
                label: 'Ingresos Semanales',
                data: @json($weeklyRevenue->pluck('total')),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx = document.getElementById('monthlyRevenueChart').getContext('2d');
    var monthlyRevenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($monthlyRevenue->map(function($item) {
                return $item->month . '/' . $item->year;
            })),
            datasets: [{
                label: 'Ingresos Mensuales',
                data: @json($monthlyRevenue->pluck('total')),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
