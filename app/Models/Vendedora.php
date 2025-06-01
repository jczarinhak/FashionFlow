<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Venda;

class Vendedora extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'comissao'
    ];

}
