@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Devolução para Venda #{{ $venda->id }}</h1>

    <form method="POST" action="{{ route('devolucoes.store', $venda->id) }}">
        @csrf

        <!-- Seleção de Produtos -->
        <div class="mb-6">
            <h3 class="font-semibold mb-3">Produtos Vendidos:</h3>
            @foreach($venda->produtos as $produto)
                <div class="flex items-center mb-3">
                    <input 
                        type="checkbox" 
                        name="produtos_devolvidos[]" 
                        value="{{ $produto->id }}" 
                        id="prod-{{ $produto->id }}" 
                        class="form-checkbox h-5 w-5 text-red-600"
                    >
                    <label for="prod-{{ $produto->id }}" class="ml-3 flex-1">
                        {{ $produto->nome }} (Qtd: {{ $produto->pivot->quantidade }})
                    </label>
                    <input 
                        type="number" 
                        name="quantidades[{{ $produto->id }}]" 
                        min="1" 
                        max="{{ $produto->pivot->quantidade }}" 
                        value="{{ $produto->pivot->quantidade }}" 
                        class="border border-gray-300 rounded px-3 py-1 w-20"
                        placeholder="Qtd"
                    >
                </div>
            @endforeach
        </div>

        <!-- Motivo -->
        <div class="mb-6">
            <label for="motivo" class="block font-semibold mb-2">Motivo:</label>
            <select name="motivo" id="motivo" class="border border-gray-300 rounded w-full p-2" required>
                <option value="" disabled selected>Selecione o motivo</option>
                <option value="Tamanho errado">Tamanho errado</option>
                <option value="Defeito">Defeito no produto</option>
                <option value="Arrependimento">Arrependimento</option>
                <option value="Outro">Outro</option>
            </select>
        </div>

        <!-- Valor Estornado -->
        <div class="mb-6">
            <label for="valor_estornado" class="block font-semibold mb-2">Valor Estornado:</label>
            <input 
                type="number" 
                name="valor_estornado" 
                id="valor_estornado" 
                step="0.01" 
                min="0" 
                class="border border-gray-300 rounded w-full p-2" 
                required
                placeholder="0,00"
            >
        </div>

        <!-- Data da Devolução -->
        <div class="mb-6">
            <label for="data_devolucao" class="block font-semibold mb-2">Data da Devolução:</label>
            <input 
                type="date" 
                name="data_devolucao" 
                id="data_devolucao" 
                class="border border-gray-300 rounded w-full p-2" 
                required
                value="{{ date('Y-m-d') }}"
            >
        </div>

        <div class="flex space-x-4">
    <button type="submit" class="text-black px-6 py-2 rounded font-semibold border border-gray-300 hover:bg-gray-100">
        Confirmar Devolução
    </button>
    <a href="{{ route('vendas.show', $venda->id) }}" class="text-black px-6 py-2 rounded font-semibold border border-gray-300 hover:bg-gray-100">
        Cancelar
    </a>
</div>

    </form>
</div>
@endsection
