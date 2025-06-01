@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cadastrar Nova Vendedora</h1>

    {{-- Exibir erros de validação --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('vendedoras.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="comissao" class="form-label">Comissão (de 0 a 0.5 → 0.1 = 10%)</label>
            <input type="number" step="0.01" class="form-control" id="comissao" 
                   name="comissao" value="{{ old('comissao', 0.1) }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
