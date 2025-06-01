<?php

namespace App\Http\Controllers;

use App\Models\Vendedora;
use Illuminate\Http\Request;

class VendedoraController extends Controller
{
    // Exibe todas as vendedoras, incluindo as excluídas (soft deleted)
    public function index()
    {  
        // Paginando as vendedoras, 10 por página
        $vendedoras = Vendedora::withTrashed()->paginate(10);

        return view('vendedoras.index', compact('vendedoras'));
    }

    // Exibe o formulário para criar uma nova vendedora
    public function create()
    {
        return view('vendedoras.create');
    }

    // Armazena uma nova vendedora no banco de dados
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:100',
            'email' => 'required|email|unique:vendedoras,email',
            'telefone' => 'required',
            'comissao' => 'required|numeric|min:0|max:0.5'
        ]);

        Vendedora::create($validated);

        return redirect()->route('vendedoras.index')
                         ->with('success', 'Vendedora cadastrada com sucesso!');
    }

    // Exibe o formulário de edição de uma vendedora
    public function edit($id)
    {
        $vendedora = Vendedora::findOrFail($id);
        return view('vendedoras.edit', compact('vendedora'));
    }

    // Atualiza as informações de uma vendedora no banco de dados
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nome' => 'required|max:100',
            'email' => 'required|email|unique:vendedoras,email,' . $id,
            'telefone' => 'required',
            'comissao' => 'required|numeric|min:0|max:0.5'
        ]);

        $vendedora = Vendedora::findOrFail($id);
        $vendedora->update($validated);

        return redirect()->route('vendedoras.index')
                         ->with('success', 'Vendedora atualizada com sucesso!');
    }

    // Exclui a vendedora logicamente (move para a lixeira)
    public function destroy($id)
    {
        $vendedora = Vendedora::findOrFail($id);
        $vendedora->delete();  // Exclusão lógica

        return redirect()->route('vendedoras.index')
                         ->with('success', 'Vendedora movida para a lixeira com sucesso!');
    }

    // Exibe as vendedoras que foram excluídas (soft deleted)
    public function lixeira()
    {
        // Paginando as vendedoras excluídas, 10 por página
        $vendedoras = Vendedora::onlyTrashed()->paginate(10);

        return view('vendedoras.lixeira', compact('vendedoras'));
    }

    // Restaura uma vendedora da lixeira
    public function restore($id)
    {
        $vendedora = Vendedora::withTrashed()->findOrFail($id);
        $vendedora->restore();  // Restaura a vendedora

        return redirect()->route('vendedoras.lixeira')
                         ->with('success', 'Vendedora restaurada com sucesso!');
    }

    // Exclui permanentemente uma vendedora
    public function forceDelete($id)
    {
        $vendedora = Vendedora::withTrashed()->findOrFail($id);
        $vendedora->forceDelete();  // Exclui permanentemente

        return redirect()->route('vendedoras.lixeira')
                         ->with('success', 'Vendedora excluída permanentemente!');
    }
}
