{{-- resources/views/devolucoes/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <h1 class="text-lg font-semibold mb-6 text-gray-900">
        Todas as Devoluções
    </h1>

    <div class="overflow-x-auto border border-gray-300 rounded-lg shadow-sm">
        <table class="min-w-full bg-white divide-y divide-gray-200 text-sm">

            <thead class="sr-only">
                {{-- Cabeçalho oculto, pois mostraremos título em cada célula --}}
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
