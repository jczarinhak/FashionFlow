<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaFiscal extends Model
{
    protected $table = 'notas_fiscais';

    protected $fillable = [
        'venda_id',
        'numero',
        'data_emissao',
        'valor_total',
        'status',
    ];
}
