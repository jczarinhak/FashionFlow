@extends('layouts.app')

@section('content')
    <h1>Lixeira de Vendas</h1>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if($vendas->count() > 0)
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Vendedora</th>
                    <th>Data da Venda</th>
                    <th>Valor Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendas as $venda)
                    <tr>
                        <td>{{ $venda->id }}</td>
                        <td>{{ $venda->cliente->nome ?? '—' }}</td>
                        <td>{{ $venda->vendedora->nome ?? '—' }}</td>
                        <td>{{ $venda->data_venda }}</td>
                        <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('vendas.restore', $venda->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PUT')
                                <button type="submit" onclick="return confirm('Restaurar essa venda?')">Restaurar</button>
                            </form>

                            <form action="{{ route('vendas.force-delete', $venda->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Excluir permanentemente essa venda?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $vendas->links() }}
    @else
        <p>Não há vendas na lixeira.</p>
    @endif
@endsection
