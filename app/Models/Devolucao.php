<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devolucao extends Model
{
    protected $table = 'devolucoes'; 
    protected $fillable = ['venda_id', 'motivo', 'valor_estornado', 'data_devolucao'];

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }
}