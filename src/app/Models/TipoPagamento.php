<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPagamento extends Model
{
    use HasFactory;

    protected $table = 'tipos_pagamento';

    protected $fillable = [
        'nome',
        'descricao',
        'status'
    ];

    public function vendas()
    {
        return $this->hasMany(Venda::class, 'tipo_pagamento_id');
    }
}
