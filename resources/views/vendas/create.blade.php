@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Criar Nova Venda</h1>

    <form method="POST" action="{{ route('vendas.store') }}">
        @csrf

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                <option value="">Selecione o cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="vendedora_id" class="form-label">Vendedora</label>
            <select name="vendedora_id" id="vendedora_id" class="form-select" required>
                <option value="">Selecione a vendedora</option>
                @foreach($vendedoras as $vendedora)
                    <option value="{{ $vendedora->id }}">{{ $vendedora->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="data_venda" class="form-label">Data da Venda</label>
            <input type="date" name="data_venda" id="data_venda" class="form-control" required>
        </div>

        <h4>Produtos</h4>
        <div id="produtos-container">
            <div class="mb-3 produto">
                <label for="produto_id[]" class="form-label">Produto</label>
                <select name="produtos[0][produto_id]" class="form-select produto-id" required>
                    <option value="">Selecione o produto</option>
                    @foreach($produtos as $produto)
                        <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                    @endforeach
                </select>
                <label for="quantidade[]" class="form-label">Quantidade</label>
                <input type="number" name="produtos[0][quantidade]" class="form-control quantidade" min="1" required>
            </div>
        </div>

        <button type="button" class="btn btn-secondary" id="add-produto">Adicionar Produto</button>
        <br><br>
        <button type="submit" class="btn btn-success">Registrar Venda</button>
    </form>
</div>

<script>
    let produtoCount = 1;

    document.getElementById('add-produto').addEventListener('click', function () {
        let produtoDiv = document.createElement('div');
        produtoDiv.classList.add('mb-3', 'produto');

        produtoDiv.innerHTML = `
            <label for="produto_id[]" class="form-label">Produto</label>
            <select name="produtos[${produtoCount}][produto_id]" class="form-select produto-id" required>
                <option value="">Selecione o produto</option>
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                @endforeach
            </select>
            <label for="quantidade[]" class="form-label">Quantidade</label>
            <input type="number" name="produtos[${produtoCount}][quantidade]" class="form-control quantidade" min="1" required>
        `;

        document.getElementById('produtos-container').appendChild(produtoDiv);
        produtoCount++;
    });
</script>
@endsection
