@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-chart-bar"></i> Vendas vs Devoluções 
                    </h3>
                </div>
                <div class="card-body">
                    <div id="chart-data"
                        data-labels='@json($data["labels"])'
                        data-vendas='@json($data["vendas"])'
                        data-devolucoes='@json($data["devolucoes"])'>
                    </div>
                    <div class="chart-container" style="position: relative; height:400px;">
                        <canvas id="chartVendasDevolucoes"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .chart-container {
        min-height: 400px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartDataDiv = document.getElementById('chart-data');

        // Lendo os dados dos data-attributes e parseando JSON
        const labels = JSON.parse(chartDataDiv.dataset.labels);
        const vendas = JSON.parse(chartDataDiv.dataset.vendas);
        const devolucoes = JSON.parse(chartDataDiv.dataset.devolucoes);

        const ctx = document.getElementById('chartVendasDevolucoes').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Vendas (R$)',
                        data: vendas,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Devoluções (R$)',
                        data: devolucoes,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + value.toLocaleString('pt-BR');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': R$ ' + context.raw.toLocaleString('pt-BR', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
