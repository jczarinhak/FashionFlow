@extends('layouts.app')

@section('title', 'FashionFlow')

@section('content')
<div class="text-center mb-5">
    <h1 class="display-4">Bem-vindo ao FashionFlow</h1>
    <p class="lead">Gerencie seu estoque, vendas, clientes e vendedoras de forma eficiente.</p>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 border-primary">
            <div class="card-body text-center">
                <i class="fas fa-tshirt fa-3x text-primary mb-3"></i>
                <h3 class="card-title">Produtos</h3>
                <p class="card-text">Gerencie seu catálogo de produtos e mantenha o estoque atualizado.</p>
                <a href="{{ route('produtos.index') }}" class="btn btn-primary stretched-link">
                    Acessar <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card h-100 border-success">
            <div class="card-body text-center">
                <i class="fas fa-user-tie fa-3x text-success mb-3"></i>
                <h3 class="card-title">Vendedoras</h3>
                <p class="card-text">Administre sua equipe de vendedoras e comissões.</p>
                <a href="{{ route('vendedoras.index') }}" class="btn btn-success stretched-link">
                    Acessar <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card h-100 border-info">
            <div class="card-body text-center">
                <i class="fas fa-users fa-3x text-info mb-3"></i>
                <h3 class="card-title">Clientes</h3>
                <p class="card-text">Gerencie seu cadastro de clientes e histórico de compras.</p>
                <a href="{{ route('clientes.index') }}" class="btn btn-info stretched-link">
                    Acessar <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card border-warning">
            <div class="card-body text-center">
                <i class="fas fa-chart-line fa-3x text-warning mb-3"></i>
                <h3 class="card-title">Relatórios</h3>
                <p class="card-text">Acompanhe o desempenho da loja com relatórios detalhados.</p>
                <a href="{{ route('relatorios.vendas-vs-devolucoes') }}" class="btn btn-warning">
                Acessar <i class="fas fa-clock ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
