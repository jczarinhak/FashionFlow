<?php

namespace App\Exports;

use App\Models\Devolucao;
use Maatwebsite\Excel\Concerns\FromCollection;

class DevolucoesExport implements FromCollection
{
    public function collection()
    {
        return Devolucao::all();
    }
}
