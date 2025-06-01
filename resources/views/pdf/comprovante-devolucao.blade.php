{{-- resources/views/pdf/comprovante-devolucao.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Comprovante de Devolução #{{ $devolucao->id }}</h2>
        <p>Data: {{ $devolucao->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <table class="table">
        <tr>
            <th>Cliente</th>
            <td>{{ $devolucao->venda->cliente->nome }}</td>
        </tr>
        <tr>
            <th>Valor Estornado</th>
            <td>R$ {{ number_format($devolucao->valor_estornado, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Método</th>
            <td>{{ strtoupper($devolucao->metodo_estorno) }}</td>
        </tr>
    </table>

    <h3 style="margin-top: 30px;">Produtos Devolvidos:</h3>
    <ul>
        @foreach($devolucao->venda->produtos as $produto)
        <li>{{ $produto->nome }} - {{ $produto->pivot->quantidade }} un.</li>
        @endforeach
    </ul>
</body>
</html>