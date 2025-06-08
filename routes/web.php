<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendedoraController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DevolucaoController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\NotaFiscalController;
// =================== ROTAS PRINCIPAIS ===================
// Rota da Home
Route::get('/', function () {
    return view('home');
})->name('home');

// =================== PRODUTOS ===================
Route::prefix('produtos')->group(function () {
    Route::get('/', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('/create', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::post('/', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::get('/{id}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit');
    Route::put('/{id}', [ProdutoController::class, 'update'])->name('produtos.update');
    Route::delete('/{id}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');

    Route::prefix('lixeira')->group(function () {
        Route::get('/', [ProdutoController::class, 'lixeira'])->name('produtos.lixeira');
        Route::put('/{id}/restore', [ProdutoController::class, 'restore'])->name('produtos.restore');
        Route::delete('/{id}/force-delete', [ProdutoController::class, 'forceDelete'])->name('produtos.force-delete');
    });
});

// =================== VENDEDORAS ===================
Route::prefix('vendedoras')->group(function () {
    Route::get('/', [VendedoraController::class, 'index'])->name('vendedoras.index');
    Route::get('/create', [VendedoraController::class, 'create'])->name('vendedoras.create');
    Route::post('/', [VendedoraController::class, 'store'])->name('vendedoras.store');
    Route::get('/{id}/edit', [VendedoraController::class, 'edit'])->name('vendedoras.edit');
    Route::put('/{id}', [VendedoraController::class, 'update'])->name('vendedoras.update');
    Route::delete('/{id}', [VendedoraController::class, 'destroy'])->name('vendedoras.destroy');

    Route::prefix('lixeira')->group(function () {
        Route::get('/', [VendedoraController::class, 'lixeira'])->name('vendedoras.lixeira');
        Route::put('/{id}/restore', [VendedoraController::class, 'restore'])->name('vendedoras.restore');
        Route::delete('/{id}/force-delete', [VendedoraController::class, 'forceDelete'])->name('vendedoras.force-delete');
    });
});

// =================== CLIENTES ===================
Route::prefix('clientes')->group(function () {
    Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/{id}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

    Route::prefix('lixeira')->group(function () {
        Route::get('/', [ClienteController::class, 'lixeira'])->name('clientes.lixeira');
        // Alterado para POST (evita problemas com alguns browsers)
        Route::post('/{id}/restore', [ClienteController::class, 'restore'])->name('clientes.restore');
        Route::delete('/{id}/force-delete', [ClienteController::class, 'forceDelete'])->name('clientes.force-delete');
    });
});

// =================== DEVOLUÇÕES ===================
Route::prefix('vendas/{venda}/devolucao')->group(function () {
    Route::get('/create', [DevolucaoController::class, 'create'])->name('devolucoes.create');
    Route::post('/', [DevolucaoController::class, 'store'])->name('devolucoes.store');
});

Route::get('/devolucoes', [DevolucaoController::class, 'index'])->name('devolucoes.index');
Route::get('/devolucoes/{devolucao}/comprovante', [DevolucaoController::class, 'downloadComprovante'])
     ->name('devolucoes.comprovante');

// =================== VENDAS ===================
Route::resource('vendas', VendaController::class);

// Rotas da lixeira - fora do resource para evitar conflito
Route::prefix('vendas/lixeira')->group(function () {
    Route::get('/', [VendaController::class, 'lixeira'])->name('vendas.lixeira');
    Route::put('/{id}/restore', [VendaController::class, 'restore'])->name('vendas.restore');
    Route::delete('/{id}/force-delete', [VendaController::class, 'forceDelete'])->name('vendas.force-delete');
});

// =================== RELATÓRIOS ===================
Route::prefix('relatorios')->group(function () {
    Route::get('/', [RelatorioController::class, 'index'])->name('relatorios.index');

    Route::get('devolucoes', [RelatorioController::class, 'devolucoes'])->name('relatorios.devolucoes');
    Route::get('vendas-vs-devolucoes', [RelatorioController::class, 'vendasVsDevolucoes'])->name('relatorios.vendas-vs-devolucoes');
    Route::get('export-excel', [RelatorioController::class, 'exportExcel'])->name('relatorios.export-excel');
    Route::get('export-pdf', [RelatorioController::class, 'exportPdf'])->name('relatorios.export-pdf');

    Route::get('vendas', [VendaController::class, 'gerarRelatorio'])->name('relatorios.vendas');
    Route::get('devolucoes-geral', [DevolucaoController::class, 'gerarRelatorio'])->name('relatorios.devolucoes-geral');
});

// =================== API (webhook MercadoPago) ===================
Route::post('/webhook/mercadopago', [DevolucaoController::class, 'webhookMercadoPago'])
     ->name('webhook.mercadopago')
     ->withoutMiddleware(['csrf']);

// =================== AUTENTICAÇÃO ===================
// Logout
Route::post('/logout', function () {
    session()->flush();
    return redirect()->route('home');
})->name('logout');

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// =================== Chart ===================
Route::get('/charts', [ChartController::class, 'index'])->name('charts.index');

// =================== routes/web.php ===================
Route::post('/vendas/{venda}/emitir-nota', [NotaFiscalController::class, 'emitir'])
     ->name('vendas.emitir-nota');