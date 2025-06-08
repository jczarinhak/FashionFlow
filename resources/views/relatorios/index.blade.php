{{-- resources/views/relatorios/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-semibold mb-8 text-center">Relatório Mensal da Loja</h1>

    <form method="GET" action="{{ route('relatorios.index') }}" class="mb-3 text-center">
        <label for="mes" class="mr-2">Filtrar por mês:</label>
        <input type="month" id="mes" name="mes" value="{{ $mesSelecionado }}" class="border rounded px-3 py-1">
        <button type="submit" class="bg-yellow-300 text-black px-4 py-1 rounded hover:bg-yellow-400 ml-2">
        Filtrar
        </button>
    </form>

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
