<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\Vendedora;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::with(['cliente', 'vendedora'])->latest()->paginate(10);
        return view('vendas.index', compact('vendas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $vendedoras = Vendedora::all();
        $produtos = Produto::all();

        return view('vendas.create', compact('clientes', 'vendedoras', 'produtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'vendedora_id' => 'required|exists:vendedoras,id',
            'data_venda' => 'required|date',
            'produtos' => 'required|array|min:1',
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
        ]);

        $valorTotal = 0;
        $attachData = [];

        foreach ($request->produtos as $item) {
            $produto = Produto::findOrFail($item['produto_id']);
            $quantidade = $item['quantidade'];
            $precoUnitario = $produto->preco;

            $valorTotal += $precoUnitario * $quantidade;

            $attachData[$produto->id] = [
                'quantidade' => $quantidade,
                'preco_unitario' => $precoUnitario,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $venda = Venda::create([
            'cliente_id' => $request->cliente_id,
            'vendedora_id' => $request->vendedora_id,
            'data_venda' => $request->data_venda,
            'valor_total' => $valorTotal,
        ]);

        $venda->produtos()->attach($attachData);

        return redirect()->route('vendas.index')->with('success', 'Venda registrada com sucesso!');
    }

    public function show(Venda $venda)
    {
        $venda->load(['cliente', 'vendedora', 'produtos']);
        return view('vendas.show', compact('venda'));
    }

    public function edit(Venda $venda)
    {
        $clientes = Cliente::all();
        $vendedoras = Vendedora::all();
        $produtos = Produto::all();

        $venda->load('produtos');

        return view('vendas.edit', compact('venda', 'clientes', 'vendedoras', 'produtos'));
    }

    public function update(Request $request, Venda $venda)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'vendedora_id' => 'required|exists:vendedoras,id',
            'data_venda' => 'required|date',
            'produtos' => 'required|array|min:1',
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
        ]);

        $valorTotal = 0;
        $attachData = [];

        foreach ($request->produtos as $item) {
            $produto = Produto::findOrFail($item['produto_id']);
            $quantidade = $item['quantidade'];
            $precoUnitario = $produto->preco;

            $valorTotal += $precoUnitario * $quantidade;

            $attachData[$produto->id] = [
                'quantidade' => $quantidade,
                'preco_unitario' => $precoUnitario,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $venda->update([
            'cliente_id' => $request->cliente_id,
            'vendedora_id' => $request->vendedora_id,
            'data_venda' => $request->data_venda,
            'valor_total' => $valorTotal,
        ]);

        $venda->produtos()->sync($attachData);

        return redirect()->route('vendas.index')->with('success', 'Venda atualizada com sucesso!');
    }

    public function destroy(Venda $venda)
    {
        $venda->produtos()->detach();
        $venda->delete();

        return redirect()->route('vendas.index')->with('success', 'Venda excluída.');
    }

    public function lixeira()
    {
        $vendas = Venda::onlyTrashed()->with(['cliente', 'vendedora'])->latest()->paginate(10);
        return view('vendas.lixeira', compact('vendas'));
    }

    public function restore($id)
    {
        $venda = Venda::onlyTrashed()->findOrFail($id);
        $venda->restore();

        return redirect()->route('vendas.lixeira')->with('success', 'Venda restaurada com sucesso!');
    }

    public function forceDelete($id)
    {
        $venda = Venda::onlyTrashed()->findOrFail($id);
        $venda->produtos()->detach();
        $venda->forceDelete();

        return redirect()->route('vendas.lixeira')->with('success', 'Venda excluída permanentemente.');
    }

    public function gerarRelatorio()
    {
        $vendas = Venda::with(['cliente', 'vendedora', 'produtos'])->get();

        $pdf = Pdf::loadView('relatorios.vendas', compact('vendas'));

        return $pdf->download('relatorio_vendas.pdf');
    }
}
