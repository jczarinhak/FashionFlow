<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClienteController extends Controller
{
    // Método para exibir a lista de clientes
    public function index()
    {
        $clientes = Cliente::paginate(10); // ou qualquer quantidade por página
        return view('clientes.index', compact('clientes'));
    }
    

    // Método para exibir o formulário de criação de cliente
    public function create()
    {
        return view('clientes.create');
    }

    // Método para armazenar um novo cliente no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'required|string|max:15',
            'cpf' => 'required|string|max:14',
            'data_nascimento' => 'nullable|date',
            'endereco' => 'nullable|string',
        ]);

        Cliente::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento ? Carbon::parse($request->data_nascimento) : null,
            'endereco' => $request->endereco,
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso!');
    }

    // Método para exibir o formulário de edição de um cliente
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);

        // Verifica se a data de nascimento existe e se não é uma instância de Carbon
        if ($cliente->data_nascimento && !$cliente->data_nascimento instanceof Carbon) {
            // Converte a data de nascimento para um objeto Carbon e formata
            $cliente->data_nascimento = Carbon::parse($cliente->data_nascimento)->format('Y-m-d');
        }

        return view('clientes.edit', compact('cliente'));
    }

    // Método para atualizar os dados de um cliente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email,' . $id,
            'telefone' => 'required|string|max:15',
            'cpf' => 'required|string|max:14',
            'data_nascimento' => 'nullable|date',
            'endereco' => 'nullable|string',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento ? Carbon::parse($request->data_nascimento) : null,
            'endereco' => $request->endereco,
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    // Método para excluir um cliente
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }

    // Método para exibir a lixeira de clientes excluídos
    public function lixeira()
    {
        $clientes = Cliente::onlyTrashed()->paginate(10); // também aqui
        return view('clientes.lixeira', compact('clientes'));
    }
    

    // Método para restaurar um cliente da lixeira
    public function restore($id)
    {
        $cliente = Cliente::onlyTrashed()->findOrFail($id);
        $cliente->restore();

        return redirect()->route('clientes.lixeira')->with('success', 'Cliente restaurado com sucesso!');
    }

    // Método para forçar a exclusão de um cliente
    public function forceDelete($id)
    {
        $cliente = Cliente::onlyTrashed()->findOrFail($id);
        $cliente->forceDelete();

        return redirect()->route('clientes.lixeira')->with('success', 'Cliente excluído permanentemente!');
    }
}
