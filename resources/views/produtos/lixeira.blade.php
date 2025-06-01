<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lixeira - Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Ícones FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    @include('header')

    <div class="container mt-5">
        <h1>Lixeira de Produtos</h1>

        <!-- Formulário de busca -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <form action="{{ route('produtos.lixeira') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Buscar na lixeira..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit" title="Buscar" aria-label="Buscar">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <span class="badge bg-secondary fs-6">
                    {{ $produtos->total() }} item{{ $produtos->total() === 1 ? '' : 's' }} encontrado{{ $produtos->total() === 1 ? '' : 's' }}
                </span>
            </div>
        </div>

        <!-- Mensagens de feedback -->
       

        <!-- Botão de voltar -->
        <a href="{{ route('produtos.index') }}" class="btn btn-primary mb-3">
            &laquo; Voltar para Produtos
        </a>

        <!-- Tabela de produtos excluídos -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Excluído em</th>
                        <th style="width: 240px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produtos as $produto)
                        <tr>
                            <td>{{ $produto->id }}</td>
                            <td>{{ $produto->nome }}</td>
                            <td>
                                {{ $produto->deleted_at->format('d/m/Y H:i') }}<br>
                                <small class="text-muted">({{ $produto->deleted_at->diffForHumans() }})</small>
                            </td>
                            <td>
                                <form action="{{ route('produtos.restore', $produto->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm" title="Restaurar produto" aria-label="Restaurar produto">
                                        Restaurar
                                    </button>
                                </form>
                                <form action="{{ route('produtos.force-delete', $produto->id) }}" method="POST" class="d-inline ms-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Tem certeza que deseja excluir PERMANENTEMENTE este produto?')" 
                                            title="Excluir permanentemente" aria-label="Excluir permanentemente">
                                        Excluir Permanentemente
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhum produto encontrado na lixeira.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <div class="d-flex justify-content-center mt-4">
            {{ $produtos->appends(request()->query())->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
