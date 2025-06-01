<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venda extends Model
{
    use SoftDeletes;

    protected $fillable = ['cliente_id', 'vendedora_id', 'data_venda', 'valor_total'];

    protected $casts = [
        'data_venda' => 'datetime',
    ];

    protected $dates = ['deleted_at']; // opcional com Laravel >= 7, mas pode manter

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function vendedora()
    {
        return $this->belongsTo(Vendedora::class);
    }

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'produto_venda')
            ->withPivot('quantidade', 'preco_unitario')
            ->withTimestamps();
    }

    public function devolucoes()
    {
        return $this->hasMany(Devolucao::class);
    }
}
