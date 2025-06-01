<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Vendas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Relatório de Vendas</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Vendedora</th>
                <th>Data</th>
                <th>Produtos</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendas as $venda)
                <tr>
                    <td>{{ $venda->id }}</td>
                    <td>{{ $venda->cliente->nome }}</td>
                    <td>{{ $venda->vendedora->nome }}</td>
                    <td>{{ $venda->data_venda }}</td>
                    <td>
                        <ul>
                            @foreach ($venda->produtos as $produto)
                                <li>{{ $produto->nome }} ({{ $produto->pivot->quantidade }} x R$ {{ number_format($produto->pivot->preco_unitario, 2, ',', '.') }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
