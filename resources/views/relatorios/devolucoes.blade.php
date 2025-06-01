<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Devoluções</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Relatório de Devoluções</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Cliente</th>
                <th>Motivo</th>
                <th>Valor Estornado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($devolucoes as $devolucao)
                <tr>
                    <td>{{ $devolucao->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($devolucao->created_at)->format('d/m/Y') }}</td>
                    <td>{{ $devolucao->venda->cliente->nome ?? 'N/A' }}</td>
                    <td>{{ $devolucao->motivo }}</td>
                    <td>R$ {{ number_format($devolucao->valor_estornado, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Total Estornado: R$ {{ number_format($totalEstornado, 2, ',', '.') }}</p>
</body>
</html>
