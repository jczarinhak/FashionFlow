@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clientes</h1>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">Novo Cliente</a>
        <a href="{{ route('clientes.lixeira') }}" class="btn btn-secondary">Ver Lixeira</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    @endif

    <form method="GET" action="{{ route('clientes.index') }}" class="mb-3">
        <input type="text" name="busca" class="form-control" placeholder="Buscar cliente...">
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>CPF</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
            <tr>
                <td>{{ $cliente->nome }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->telefone }}</td>
                <td>{{ $cliente->cpf }}</td>
                <td>
                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Tem certeza que deseja excluir?')">
                            Excluir
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Nenhum cliente encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $clientes->links() }}
</div>
@endsection
