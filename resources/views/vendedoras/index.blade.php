<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendedoras - Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('header')

    <div class="container mt-5">
        <h1>Lista de Vendedoras</h1>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('vendedoras.create') }}" class="btn btn-primary mb-3">
            Cadastrar Nova Vendedora
        </a>

        <!-- Botão para exibir a lixeira -->
        <a href="{{ route('vendedoras.lixeira') }}" class="btn btn-secondary mb-3">
            Vendedoras Excluídas
        </a>

        <!-- Exibir o total de vendedoras -->
        <span class="badge bg-secondary mb-3">
            Total de Vendedoras: {{ $vendedoras->total() }}
        </span>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Comissão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendedoras as $vendedora)
                    <tr>
                        <td>{{ $vendedora->id }}</td>
                        <td>{{ $vendedora->nome }}</td>
                        <td>{{ $vendedora->email }}</td>
                        <td>{{ $vendedora->telefone }}</td>
                        <td>{{ $vendedora->comissao * 100 }}%</td>
                        <td>
                            <a href="{{ route('vendedoras.edit', $vendedora->id) }}" class="btn btn-warning btn-sm">Editar</a>

                            @if($vendedora->trashed())
                                <!-- Formulário para restaurar a vendedora (corrigido) -->
                                <form action="{{ route('vendedoras.restore', $vendedora->id) }}" method="POST" 
                                      style="display:inline-block;" 
                                      onsubmit="return confirm('Tem certeza que deseja restaurar esta vendedora?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                                </form>

                                <!-- Formulário para excluir permanentemente a vendedora -->
                                <form action="{{ route('vendedoras.force-delete', $vendedora->id) }}" method="POST" 
                                      style="display:inline-block;" 
                                      onsubmit="return confirm('Tem certeza que deseja excluir permanentemente esta vendedora?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Excluir Permanentemente</button>
                                </form>
                            @else
                                <!-- Formulário para excluir a vendedora (soft delete) -->
                                <form action="{{ route('vendedoras.destroy', $vendedora->id) }}" method="POST" 
                                      style="display:inline-block;" 
                                      onsubmit="return confirm('Tem certeza que deseja excluir esta vendedora?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Links de navegação da paginação -->
        <div class="d-flex justify-content-center mt-4">
            {{ $vendedoras->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
