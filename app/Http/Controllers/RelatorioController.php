<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devolucao;
use App\Models\Venda;
use App\Models\Vendedora;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DevolucoesExport;

class RelatorioController extends Controller
{
    /**
     * Página principal dos relatórios
     * Mostra lucro total do mês, salário das vendedoras e total de devoluções.
     */
    public function index(Request $request)
    {
        // Filtro por mês (formato: YYYY-MM). Se não houver, usa o mês atual.
        $mesSelecionado = $request->input('mes'); // Ex: "2025-06"
        $data = $mesSelecionado ? Carbon::createFromFormat('Y-m', $mesSelecionado) : Carbon::now();

        $inicioMes = $data->copy()->startOfMonth();
        $fimMes = $data->copy()->endOfMonth();

        // Vendas do mês com vendedoras
        $vendas = Venda::whereBetween('created_at', [$inicioMes, $fimMes])
            ->with('vendedora')
            ->get();

        // Lucro bruto: total das vendas - custos
        $lucroBruto = $vendas->reduce(function ($carry, $venda) {
            return $carry + ($venda->valor_total - $venda->custo_total);
        }, 0);

        // Comissões das vendedoras
        $comissaoTotal = $vendas->reduce(function ($carry, $venda) {
            return $carry + ($venda->valor_total * ($venda->vendedora->comissao ?? 0));
        }, 0);

        // Total devolvido no mês
        $totalDevolucoes = Devolucao::whereBetween('created_at', [$inicioMes, $fimMes])
            ->sum('valor_estornado');

        // Lucro final = lucro bruto - devoluções - comissões
        $lucroFinal = $lucroBruto - $totalDevolucoes - $comissaoTotal;

        return view('relatorios.index', [
            'lucroTotal' => $lucroFinal,
            'salarios' => $comissaoTotal,
            'totalDevolucoes' => $totalDevolucoes,
            'mesSelecionado' => $data->format('Y-m')
        ]);
    }

    /**
     * Monta a query base para busca de devoluções com filtros opcionais.
     */
    private function devolucoesQuery(Request $request)
    {
        $query = Devolucao::with(['venda.cliente']);

        if ($request->filled('periodo')) {
            $periodo = explode(' - ', $request->periodo);
            if (count($periodo) === 2) {
                $inicio = Carbon::createFromFormat('d/m/Y', trim($periodo[0]))->startOfDay();
                $fim = Carbon::createFromFormat('d/m/Y', trim($periodo[1]))->endOfDay();
                $query->whereBetween('created_at', [$inicio, $fim]);
            }
        }

        if ($request->filled('motivo')) {
            $query->where('motivo', $request->motivo);
        }

        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Relatório HTML de devoluções com filtros e total estornado.
     */
    public function devolucoes(Request $request)
    {
        $query = $this->devolucoesQuery($request);
        $devolucoes = $query->get();
        $totalEstornado = $devolucoes->sum('valor_estornado');

        return view('relatorios.devolucoes', compact('devolucoes', 'totalEstornado'));
    }

    /**
     * Exporta relatório de devoluções em Excel.
     */
    public function exportExcel(Request $request)
    {
        $query = $this->devolucoesQuery($request);
        return Excel::download(new DevolucoesExport($query), 'devolucoes.xlsx');
    }

    /**
     * Exporta relatório de devoluções em PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = $this->devolucoesQuery($request);
        $devolucoes = $query->get();
        $totalEstornado = $devolucoes->sum('valor_estornado');

        $pdf = Pdf::loadView('relatorios.devolucoes-pdf', compact('devolucoes', 'totalEstornado'));
        return $pdf->download('relatorio_devolucoes.pdf');
    }

    /**
     * Gráfico de vendas vs devoluções dos últimos 6 meses.
     */
    public function vendasVsDevolucoes()
    {
        $labels = [];
        $vendas = [];
        $devolucoes = [];

        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $mesAno = $data->format('M/Y');

            $labels[] = $mesAno;

            $inicioMes = $data->copy()->startOfMonth();
            $fimMes = $data->copy()->endOfMonth();

            $vendasMes = Venda::whereBetween('created_at', [$inicioMes, $fimMes])
                ->sum('valor_total');
            $vendas[] = $vendasMes;

            $devolucoesMes = Devolucao::whereBetween('created_at', [$inicioMes, $fimMes])
                ->sum('valor_estornado');
            $devolucoes[] = $devolucoesMes;
        }

        $data = [
            'labels' => $labels,
            'vendas' => $vendas,
            'devolucoes' => $devolucoes,
        ];

        return view('relatorios.vendas-vs-devolucoes', compact('data'));
    }
}
