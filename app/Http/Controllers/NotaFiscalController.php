<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\NotaFiscal;
use Barryvdh\DomPDF\Facade\Pdf;

class NotaFiscalController extends Controller
{
    public function emitir(Venda $venda)
    {
        $numero = str_pad(NotaFiscal::count() + 1, 3, '0', STR_PAD_LEFT) . '/' . now()->year;

        $nota = NotaFiscal::create([
            'venda_id' => $venda->id,
            'numero' => $numero,
            'data_emissao' => now(),
            'valor_total' => $venda->valor_total
        ]);

        $pdf = PDF::loadView('notas_fiscais.pdf', [
            'nota' => $nota,
            'venda' => $venda
        ]);

        $numeroParaArquivo = str_replace('/', '-', $nota->numero);

        // Retorna o PDF para download
        return $pdf->download("nota_fiscal_{$numeroParaArquivo}.pdf");
    }
}
