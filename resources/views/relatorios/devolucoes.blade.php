@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Relatório de Devoluções</h1>
    
    <!-- Filtros -->
    <form method="GET" class="mb-5 p-4 bg-light rounded">
        <div class="row">
            <div class="col-md-4">
                <label>Período:</label>
                <input type="text" name="periodo" class="form-control date-range-picker">
            </div>
            <div class="col-md-4">
                <label>Motivo:</label>
                <select name="motivo" class="form-control">
                    <option value="">Todos</option>
                    <option value="Tamanho errado">Tamanho errado</option>
                    <option value="Defeito">Defeito</option>
                </select>
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('relatorios.devolucoes') }}?export=pdf" class="btn btn-danger ml-2">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
        </div>
    </form>

    <!-- Dados -->
    <div class="card">
        <div class="card-header">
            Total Estornado: <strong>R$ {{ number_format($totalEstornado, 2, ',', '.') }}</strong>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Valor</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($devolucoes as $devolucao)
                    <tr>
                        <td>{{ $devolucao->id }}</td>
                        <td>{{ $devolucao->created_at->format('d/m/Y') }}</td>
                        <td>{{ $devolucao->venda->cliente->nome }}</td>
                        <td>R$ {{ number_format($devolucao->valor_estornado, 2, ',', '.') }}</td>
                        <td>{{ $devolucao->motivo }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(function() {
        $('.date-range-picker').daterangepicker({
            locale: { format: 'DD/MM/YYYY' },
            opens: 'right'
        });
    });
</script>
@endpush