{{-- resources/views/devolucoes/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <h1 class="text-lg font-semibold mb-6 text-gray-900">
        Todas as Devoluções
    </h1>

    {{-- Formulário de filtro por mês --}}
    <form method="GET" action="{{ route('devolucoes.index') }}" class="mb-6 flex flex-wrap items-center gap-4 bg-gray-50 p-4 rounded shadow-sm max-w-md">
        <label for="mes" class="block text-gray-700 font-semibold min-w-max">
            Filtrar por mês:
        </label>
        <input
            type="month"
            id="mes"
            name="mes"
            value="{{ $mesSelecionado ?? '' }}"
            placeholder="Selecione o mês"
            class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition w-40"
        />
        <button
            type="submit"
            class="bg-white text-black font-semibold px-5 py-2 rounded-md border border-black shadow hover:bg-gray-100 transition"
        >
            Filtrar
        </button>

        @if(!empty($mesSelecionado))
            <a href="{{ route('relatorios.devolucoes', ['mes' => $mesSelecionado]) }}" target="_blank"
               class="bg-white text-black font-semibold px-5 py-2 rounded-md border border-black shadow hover:bg-gray-100 transition"
            >
                Gerar Relatório PDF
            </a>
        @endif
    </form>

    <div class="overflow-x-auto border border-gray-300 rounded-lg shadow-sm">
        <table class="min-w-full bg-white divide-y divide-gray-200 text-sm">

            <thead class="sr-only">
                {{-- Cabeçalho oculto, pois mostramos título em cada célula --}}
                <tr>
                    <th>Venda ID</th>
                    <th>Cliente</th>
                    <th>Valor Estornado</th>
                    <th>Data</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($devolucoes as $devolucao)
                    <tr class="hover:bg-gray-50">
                        {{-- Venda ID --}}
                        <td class="px-4 py-3 align-top border-r border-gray-200">
                            <div class="text-gray-500 text-xs uppercase font-semibold mb-1">Venda ID</div>
                            <a href="{{ route('vendas.show', $devolucao->venda) }}" class="text-blue-600 font-medium hover:underline">
                                #{{ $devolucao->venda->id }}
                            </a>
                        </td>

                        {{-- Cliente --}}
                        <td class="px-4 py-3 align-top border-r border-gray-200">
                            <div class="text-gray-500 text-xs uppercase font-semibold mb-1">Cliente</div>
                            <div class="text-gray-800 font-medium">
                                {{ $devolucao->venda->cliente->nome }}
                            </div>
                        </td>

                        {{-- Valor Estornado --}}
                        <td class="px-4 py-3 align-top border-r border-gray-200">
                            <div class="text-gray-500 text-xs uppercase font-semibold mb-1">Valor Estornado</div>
                            <div class="text-green-700 font-semibold">
                                R$ {{ number_format($devolucao->valor_estornado, 2, ',', '.') }}
                            </div>
                        </td>

                        {{-- Data da Devolução --}}
                        <td class="px-4 py-3 align-top">
                            <div class="text-gray-500 text-xs uppercase font-semibold mb-1">Data</div>
                            <div class="text-gray-700 font-medium">
                                {{ \Carbon\Carbon::parse($devolucao->data_devolucao)->format('d/m/Y') }}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-12 text-center text-gray-400 italic">
                            Nenhuma devolução registrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $devolucoes->links() }}
    </div>

</div>
@endsection
