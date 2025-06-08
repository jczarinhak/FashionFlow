<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venda extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cliente_id',
        'vendedora_id',
        'data_venda',
        'valor_total',
        'custo_total', // Adicionado para cálculo do lucro
    ];

    protected $casts = [
        'data_venda' => 'datetime',
    ];

    protected $dates = ['deleted_at']; // Laravel < 7.x precisa disso

    // Relacionamento com Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relacionamento com Vendedora
    public function vendedora()
    {
        return $this->belongsTo(Vendedora::class);
    }

    // Relacionamento com Produtos da Venda
    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'produto_venda')
            ->withPivot('quantidade', 'preco_unitario')
            ->withTimestamps();
    }

    // Relacionamento com Devoluções
    public function devolucoes()
    {
        return $this->hasMany(Devolucao::class);
    }
}
