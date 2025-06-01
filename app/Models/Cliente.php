<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cpf',
        'data_nascimento',
        'endereco'
    ];

    protected $dates = ['data_nascimento', 'deleted_at'];
}
