<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'quantidade',
        'numeracao',  // adiciona aqui
        'cor'
    ];
    
    protected $dates = ['deleted_at'];

    // Método para contar itens na lixeira
    public static function countInTrash()
    {
        return self::onlyTrashed()->count();
    }

    // Relacionamento com vendas (tabela pivot: produto_venda)
    public function vendas()
    {
        return $this->belongsToMany(Venda::class, 'produto_venda')
            ->withPivot('quantidade', 'preco_unitario')
            ->withTimestamps();
    }
}
