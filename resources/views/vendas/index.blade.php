@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Vendas</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    @endif

    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('vendas.create') }}" class="btn btn-primary">Nova Venda</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Vendedora</th>
                <th>Data</th>
                <th>Valor Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vendas as $venda)
            <tr>
                <td>{{ $venda->cliente->nome }}</td>
                <td>{{ $venda->vendedora->nome }}</td>
                <td>{{ $venda->data_venda->format('d/m/Y') }}</td>
                <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                <td>
                    <a href="{{ route('vendas.show', $venda->id) }}" class="btn btn-sm btn-info">Ver</a>
                    <form action="{{ route('vendas.destroy', $venda->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Nenhuma venda registrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $vendas->links() }}
</div>
@endsection
