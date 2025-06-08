<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Devolucao extends Model
{
    protected $table = 'devolucoes';

    // Definindo os campos que podem ser atribuídos em massa
    protected $fillable = [
        'venda_id',
        'usuario_id',
        'motivo',
        'valor_estornado',
        'data_devolucao',
        'codigo_transacao',
        'status',
        'data_confirmacao',
    ];

    // Se você usa timestamps padrão created_at e updated_at, mantenha true (default)
    public $timestamps = true;

    // Se quiser, pode definir o formato da data para os campos de data
    protected $dates = [
        'data_devolucao',
        'data_confirmacao',
        'created_at',
        'updated_at',
    ];

    // Relacionamento com a venda
    public function venda(): BelongsTo
    {
        return $this->belongsTo(Venda::class);
    }

    // Relacionamento com o usuário que registrou a devolução (opcional, se tiver essa coluna)
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
