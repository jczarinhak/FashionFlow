<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Devolucao;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Mail\DevolucaoProcessadaMail;
use Illuminate\Support\Facades\Mail;
use App\Events\DevolucaoConfirmadaEvent;
use Barryvdh\DomPDF\Facade\Pdf;

class DevolucaoController extends Controller
{
    public function index()
    {
        $devolucoes = Devolucao::with('venda.cliente')->latest()->paginate(10);
        // Pega o total estornado considerando todas as devoluções (não só da página atual)
        $totalEstornado = Devolucao::sum('valor_estornado');

        return view('devolucoes.index', compact('devolucoes', 'totalEstornado'));
    }

    public function create(Venda $venda)
    {
        return view('devolucoes.create', compact('venda'));
    }

    public function store(Request $request, $venda_id)
    {
        $venda = Venda::with('produtos', 'cliente')->findOrFail($venda_id);

        $request->validate([
            'produtos_devolvidos' => 'required|array',
            'produtos_devolvidos.*' => 'exists:produtos,id',
            'quantidades' => 'required|array',
            'quantidades.*' => 'integer|min:1',
            'motivo' => 'required|string|max:255',
            'data_devolucao' => 'required|date',
            'valor_estornado' => 'required|numeric|min:0',
        ]);

        foreach ($request->produtos_devolvidos as $produtoId) {
            $produtoVenda = $venda->produtos()->where('produto_id', $produtoId)->first();

            if (!$produtoVenda) {
                return back()->withErrors([
                    'produtos_devolvidos.' . $produtoId => 'Produto não encontrado na venda.',
                ])->withInput();
            }

            $quantidadeDevolvida = $request->quantidades[$produtoId] ?? 0;

            if ($quantidadeDevolvida > $produtoVenda->pivot->quantidade) {
                return back()->withErrors([
                    'quantidades.' . $produtoId => 'Quantidade devolvida maior que a vendida para o produto ' . $produtoVenda->nome,
                ])->withInput();
            }
        }

        $valorEstornado = 0;
        $produtosDevolvidos = [];

        foreach ($request->produtos_devolvidos as $produtoId) {
            $produtoVenda = $venda->produtos()->where('produto_id', $produtoId)->first();
            $quantidadeDevolvida = $request->quantidades[$produtoId];
            $precoUnitario = $produtoVenda->pivot->preco_unitario;
            $valorEstornado += $precoUnitario * $quantidadeDevolvida;

            $produtosDevolvidos[] = [
                'nome' => $produtoVenda->nome,
                'quantidade' => $quantidadeDevolvida,
                'preco_unitario' => $precoUnitario,
                'subtotal' => $precoUnitario * $quantidadeDevolvida,
            ];

            $produto = Produto::find($produtoId);
            $produto->increment('estoque', $quantidadeDevolvida);
        }

        if ($venda->forma_pagamento === 'cartao') {
            try {
                $accessToken = config('services.mercadopago.token');

                $response = Http::withToken($accessToken)
                    ->post("https://api.mercadopago.com/v1/payments/{$venda->codigo_transacao}/refunds", [
                        'amount' => $valorEstornado,
                    ]);

                if ($response->failed() || !in_array($response->json('status'), ['approved', 'refunded'])) {
                    return back()->with('error', 'Falha no estorno via Mercado Pago.');
                }
            } catch (\Exception $e) {
                Log::error('Erro ao estornar via Mercado Pago', ['erro' => $e->getMessage()]);
                return back()->with('error', 'Erro ao estornar via Mercado Pago.');
            }
        }

        if ($venda->forma_pagamento === 'pix') {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.bcb.token'),
                'Content-Type' => 'application/json',
            ])->post('https://api.bcb.gov.br/pix/devolucao', [
                'valor' => number_format($valorEstornado, 2, '.', ''),
                'txid_original' => $venda->pix_txid,
            ]);

            if (!isset($response['devolucao_realizada']) || !$response['devolucao_realizada']) {
                Log::error('Falha no estorno via PIX', [
                    'resposta' => $response->json(),
                    'venda_id' => $venda->id,
                ]);
                return back()->with('error', 'Falha ao tentar estornar via PIX.');
            }
        }

        $devolucao = Devolucao::create([
            'venda_id' => $venda->id,
            'usuario_id' => Auth::id(),
            'motivo' => $request->motivo,
            'valor_estornado' => $valorEstornado,
            'data_devolucao' => $request->data_devolucao,
            'codigo_transacao' => $venda->codigo_transacao ?? null,
        ]);

        Mail::to($venda->cliente->email)
            ->send(new DevolucaoProcessadaMail(
                $venda,
                $valorEstornado,
                $produtosDevolvidos
            ));

        return redirect()->route('vendas.show', $venda)->with('success', 'Devolução registrada com sucesso!');
    }

    public function webhookMercadoPago(Request $request)
    {
        $data = $request->all();

        if (isset($data['type']) && $data['type'] === 'payment.refund') {
            $refundId = $data['data']['id'] ?? null;

            if ($refundId) {
                $devolucao = Devolucao::where('codigo_transacao', $refundId)->first();

                if ($devolucao) {
                    $devolucao->update([
                        'status' => 'confirmado',
                        'data_confirmacao' => now()
                    ]);
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

    public function downloadComprovante($devolucao_id)
    {
        $devolucao = Devolucao::with(['venda.cliente', 'venda.produtos'])->findOrFail($devolucao_id);

        $pdf = Pdf::loadView('pdf.comprovante-devolucao', compact('devolucao'));
        return $pdf->download("comprovante-devolucao-{$devolucao_id}.pdf");
    }

    public function gerarRelatorio()
    {
        $devolucoes = Devolucao::with(['venda.cliente', 'venda.vendedora', 'venda.produtos'])->get();

        $pdf = Pdf::loadView('relatorios.devolucoes', compact('devolucoes'));

        return $pdf->download('relatorio_devolucoes.pdf');
    }
}
