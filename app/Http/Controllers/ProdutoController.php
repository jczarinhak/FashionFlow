<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable',
            'preco' => 'required|numeric',
            'quantidade' => 'required|integer',
            'numeracao' => 'nullable|string|max:50',  // ajuste se for outro tipo
            'cor' => 'nullable|string|max:50',
        ]);

        Produto::create($validated);

        return redirect()->route('produtos.index')
                         ->with('success', 'Produto criado com sucesso!');
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|max:255',
                'descricao' => 'nullable',
                'preco' => 'required|numeric|min:0',
                'quantidade' => 'required|integer|min:0',
                'numeracao' => 'nullable|string|max:50',
                'cor' => 'nullable|string|max:50',
            ]);
    
            $produto = Produto::findOrFail($id);
            $produto->update($validated);
    
            return redirect()->route('produtos.index')
                            ->with('success', 'Produto atualizado com sucesso!');
            
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([
                'error' => 'Erro ao atualizar produto: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $produto = Produto::findOrFail($id);
            $produto->delete();
    
            return redirect()->route('produtos.index')
                            ->with('success', 'Produto excluído com sucesso!');
                            
        } catch (\Exception $e) {
            return redirect()->route('produtos.index')
                            ->with('error', 'Erro ao excluir produto: ' . $e->getMessage());
        }
    }

    public function lixeira(Request $request)
    {
        $query = Produto::onlyTrashed();
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhere('numeracao', 'like', "%{$search}%")
                  ->orWhere('cor', 'like', "%{$search}%")
                  ->orWhere('id', $search);
            });
        }
        
        $produtos = $query->orderBy('deleted_at', 'desc')->paginate(10);
        
        return view('produtos.lixeira', compact('produtos'));
    }

    public function restore($id)
    {
        try {
            $produto = Produto::onlyTrashed()->findOrFail($id);
            $produto->restore();
    
            return redirect()->route('produtos.lixeira')
                            ->with('success', 'Produto restaurado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('produtos.lixeira')
                             ->with('error', 'Erro ao restaurar produto: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $produto = Produto::onlyTrashed()->findOrFail($id);
            $produto->forceDelete();
    
            return redirect()->route('produtos.lixeira')
                            ->with('success', 'Produto removido permanentemente!');
        } catch (\Exception $e) {
            return redirect()->route('produtos.lixeira')
                             ->with('error', 'Erro ao excluir permanentemente: ' . $e->getMessage());
        }
    }
}
