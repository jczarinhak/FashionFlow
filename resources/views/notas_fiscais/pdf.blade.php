<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 15px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .footer { margin-top: 30px; font-size: 12px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>NOTA FISCAL</h2>
        <p>Nº {{ $nota->numero }} | Emissão: {{ \Carbon\Carbon::parse($nota->data_emissao)->format('d/m/Y') }}</p>
    </div>

    <div class="info">
        <p><strong>Emitente:</strong> FashionFlow</p>
        <p>CNPJ: 14.261.842/0001-45 | Endereço: Rua Prefeito Antonio, 123 - Centro - Pr</p>
    </div>

    <div class="info">
        <p><strong>Cliente:</strong> {{ $venda->cliente->nome }}</p>
        <p>CPF: {{ $venda->cliente->cpf }} | Telefone: {{ $venda->cliente->telefone }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Valor Unit.</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venda->produtos as $produto)
            <tr>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->pivot->quantidade }}</td>
                <td>R$ {{ number_format($produto->pivot->preco_unitario, 2, ',', '.') }}</td>
                <td>R$ {{ number_format($produto->pivot->quantidade * $produto->pivot->preco_unitario, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align: right;">Total:</th>
                <th>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Este documento não substitui uma Nota Fiscal Eletrônica</p>
        <p>Emitido em: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
