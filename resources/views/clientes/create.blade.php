@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Cadastrar Novo Cliente</h1>
    
    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nome" class="form-label">Nome Completo*</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email*</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="telefone" class="form-label">Telefone*</label>
                <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone') }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="cpf" class="form-label">CPF*</label>
                <input type="text" class="form-control cpf-mask" id="cpf" name="cpf" value="{{ old('cpf') }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="endereco" class="form-label">Endereço</label>
            <textarea class="form-control" id="endereco" name="endereco" rows="3">{{ old('endereco') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function(){
        $('.cpf-mask').mask('000.000.000-00');
        $('#telefone').mask('(00) 00000-0000');
    });
</script>
@endpush
