{{-- resources/views/relatorios/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-semibold mb-8 text-center">Relatório Mensal da Loja</h1>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">

        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h2 class="text-gray-500 uppercase tracking-wide text-sm mb-2">Lucro do Mês</h2>
            <p class="text-green-600 font-extrabold text-3xl">
                R$ {{ number_format($lucroTotal, 2, ',', '.') }}
            </p>
        </div>

        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h2 class="text-gray-500 uppercase tracking-wide text-sm mb-2">Salário das Funcionárias</h2>
            <p class="text-red-600 font-extrabold text-3xl">
                R$ {{ number_format($salarios, 2, ',', '.') }}
            </p>
        </div>

        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h2 class="text-gray-500 uppercase tracking-wide text-sm mb-2">Devoluções no Mês</h2>
            <p class="text-yellow-600 font-extrabold text-3xl">
                R$ {{ number_format($totalDevolucoes, 2, ',', '.') }}
            </p>
        </div>

    </div>

</div>
@endsection
