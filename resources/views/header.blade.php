<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="fas fa-store me-2"></i>FashionFlow
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('produtos.*') ? 'active' : '' }}" href="{{ route('produtos.index') }}">
                        <i class="fas fa-tshirt me-1"></i> Produtos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vendedoras.*') ? 'active' : '' }}" href="{{ route('vendedoras.index') }}">
                        <i class="fas fa-user-tie me-1"></i> Vendedoras
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                        <i class="fas fa-users me-1"></i> Clientes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vendas.*') ? 'active' : '' }}" href="{{ route('vendas.index') }}">
                        <i class="fas fa-shopping-cart me-1"></i> Vendas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('devolucoes.*') ? 'active' : '' }}" href="{{ route('devolucoes.index') }}">
                        <i class="fas fa-undo-alt me-1"></i> Devoluções
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('relatorios.*') ? 'active' : '' }}" href="{{ route('relatorios.index') }}">
                       <i class="fas fa-chart-bar me-2"></i> Relatório
                  </a>
                </li>
                
            
                
</li>
            
            </ul>
            
            
            <div class="d-flex">
                <span class="navbar-text me-3">
                    <i class="fas fa-user-circle me-1"></i> Olá, Usuário
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
