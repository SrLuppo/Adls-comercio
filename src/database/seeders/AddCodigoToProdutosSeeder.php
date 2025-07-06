<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;

class AddCodigoToProdutosSeeder extends Seeder
{
    public function run(): void
    {
        $produtos = Produto::all();

        foreach ($produtos as $index => $produto) {
            // Verificar se já tem código
            if (empty($produto->codigo)) {
                $produto->update([
                    'codigo' => 'PROD' . str_pad($produto->id, 4, '0', STR_PAD_LEFT)
                ]);
            }
        }
    }
}
