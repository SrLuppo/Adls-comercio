<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'preco',
        'categoria_id',
        'classificacao_id',
        'status'
    ];

    protected $casts = [
        'preco' => 'decimal:2'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function classificacao()
    {
        return $this->belongsTo(Classificacao::class);
    }
}
