@component('mail::message')
# Devolução Processada

Olá {{ $venda->cliente->nome }},

Sua devolução no valor de **R$ {{ number_format($valor, 2, ',', '.') }}** foi concluída.

**Produtos devolvidos:**

@foreach($produtos as $produto)
- {{ $produto['nome'] }} ({{ $produto['quantidade'] }} un.)
@endforeach

@component('mail::button', ['url' => route('vendas.show', $venda)])
Ver Detalhes da Venda
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
