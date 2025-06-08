{{-- resources/views/vendas/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes da Venda</h1>

    <div class="mb-3">
        <strong>Cliente:</strong> {{ $venda->cliente->nome }} <br>
        <strong>Vendedora:</strong> {{ $venda->vendedora->nome }} <br>
        <strong>Data da Venda:</strong> {{ $venda->data_venda->format('d/m/Y') }} <br>
        <strong>Valor Total:</strong> R$ {{ number_format($venda->valor_total, 2, ',', '.') }} <br>
    </div>

    <h4>Produtos</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venda->produtos as $produto)
            <tr>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->pivot->quantidade }}</td>
                <td>R$ {{ number_format($produto->pivot->preco_unitario, 2, ',', '.') }}</td>
                <td>R$ {{ number_format($produto->pivot->quantidade * $produto->pivot->preco_unitario, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <h3 class="font-bold text-lg">Ações:</h3>
        <a 
    href="{{ route('devolucoes.create', $venda) }}" 
            class="btn bg-white text-black border border-black px-4 py-2 rounded inline-flex items-center hover:bg-gray-100"
        >
          <i class="fas fa-undo mr-2"></i> Iniciar Devolução
        </a>
    </div>

    <hr class="my-6">

    @if($venda->devolucoes->count() > 0)
        <div class="mt-8">
            <h3 class="text-xl font-bold mb-3">Histórico de Devoluções</h3>
            <table class="table table-striped table-bordered w-full">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Motivo</th>
                        <th>Valor Estornado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venda->devolucoes as $devolucao)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($devolucao->data_devolucao)->format('d/m/Y') }}</td>
                        <td>{{ $devolucao->motivo }}</td>
                        <td>R$ {{ number_format($devolucao->valor_estornado, 2, ',', '.') }}</td>
                        <td>
                        <a href="{{ route('devolucoes.comprovante', $devolucao->id) }}" 
                         class="border border-gray-400 px-3 py-1 rounded inline-flex items-center hover:bg-gray-100 transition">
                       <i class="fas fa-file-pdf mr-1"></i> Baixar Comprovante
                        </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="mt-4 text-gray-600">Nenhuma devolução registrada.</p>
    @endif

    <a href="{{ route('vendas.index') }}" class="btn btn-primary mt-6">Voltar</a>
</div>
@endsection
