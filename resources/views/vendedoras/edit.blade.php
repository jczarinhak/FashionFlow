<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Vendedora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('header')

    <div class="container mt-5">
        <h1>Editar Vendedora</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vendedoras.update', $vendedora->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', $vendedora->nome) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $vendedora->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" name="telefone" id="telefone" value="{{ old('telefone', $vendedora->telefone) }}" required>
            </div>

            <div class="mb-3">
                <label for="comissao" class="form-label">Comissão (%)</label>
                <input type="number" step="0.01" max="50" class="form-control" name="comissao" id="comissao" value="{{ old('comissao', $vendedora->comissao * 100) }}" required>
                <small class="form-text text-muted">Digite um valor entre 0 e 50 (representando %).</small>
            </div>

            <button type="submit" class="btn btn-success">Salvar Alterações</button>
            <a href="{{ route('vendedoras.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
