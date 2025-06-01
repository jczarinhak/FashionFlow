@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clientes na Lixeira</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
            <tr>
                <td>{{ $cliente->nome }}</td>
                <td>{{ $cliente->email }}</td>
                <td>
                    {{-- Formulário de RESTAURAÇÃO (POST) --}}
                    <form action="{{ route('clientes.restore', $cliente->id) }}" method="POST" style="display:inline">
                        @csrf
                        {{-- NÃO usar @method('PUT') aqui --}}
                        <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                    </form>

                    {{-- Formulário de EXCLUSÃO PERMANENTE (DELETE) --}}
                    <form action="{{ route('clientes.force-delete', $cliente->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Tem certeza que deseja excluir permanentemente este cliente?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Voltar</a>
</div>
@endsection
