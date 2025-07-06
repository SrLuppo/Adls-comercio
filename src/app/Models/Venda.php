<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'usuario_id',
        'total',
        'forma_pagamento',
        'tipo_pagamento_id',
        'observacoes',
        'status'
    ];

    protected $casts = [
        'total' => 'decimal:2'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function tipoPagamento()
    {
        return $this->belongsTo(TipoPagamento::class);
    }

    public function itens()
    {
        return $this->hasMany(VendaItem::class);
    }
}
