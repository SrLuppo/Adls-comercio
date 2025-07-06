<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoPagamento;

class TipoPagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposPagamento = [
            [
                'nome' => 'Dinheiro',
                'descricao' => 'Pagamento em dinheiro',
                'status' => 'Ativo'
            ],
            [
                'nome' => 'Cartão de Crédito',
                'descricao' => 'Pagamento com cartão de crédito',
                'status' => 'Ativo'
            ],
            [
                'nome' => 'Cartão de Débito',
                'descricao' => 'Pagamento com cartão de débito',
                'status' => 'Ativo'
            ],
            [
                'nome' => 'PIX',
                'descricao' => 'Pagamento via PIX',
                'status' => 'Ativo'
            ],
            [
                'nome' => 'Transferência Bancária',
                'descricao' => 'Pagamento via transferência bancária',
                'status' => 'Ativo'
            ],
            [
                'nome' => 'Boleto Bancário',
                'descricao' => 'Pagamento via boleto bancário',
                'status' => 'Ativo'
            ]
        ];

        foreach ($tiposPagamento as $tipo) {
            TipoPagamento::create($tipo);
        }
    }
}
