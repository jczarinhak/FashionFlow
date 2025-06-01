<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        // Exemplo: Total de vendas por mês
        $sales = DB::table('vendas')
            ->select(DB::raw('DATE_FORMAT(data_venda, "%Y-%m") as mes'), DB::raw('SUM(valor_total) as total'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return view('charts.index', compact('sales'));
    }
}
