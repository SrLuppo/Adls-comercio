<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venda;
use App\Models\VendaItem;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\User;

class VendasExemploSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar dados necessários
        $clientes = Cliente::where('status', 'Ativo')->get();
        $produtos = Produto::where('status', 'Ativo')->get();
        $usuarios = User::all();

        if ($clientes->isEmpty() || $produtos->isEmpty() || $usuarios->isEmpty()) {
            return;
        }

        // Criar algumas vendas de exemplo
        for ($i = 1; $i <= 5; $i++) {
            $cliente = $clientes->random();
            $usuario = $usuarios->random();
            $formaPagamento = ['dinheiro', 'cartao', 'pix'][array_rand(['dinheiro', 'cartao', 'pix'])];

            $venda = Venda::create([
                'cliente_id' => $cliente->id,
                'usuario_id' => $usuario->id,
                'total' => 0,
                'forma_pagamento' => $formaPagamento,
                'observacoes' => $i % 2 == 0 ? 'Venda de exemplo para teste' : null,
                'status' => 'Concluida',
                'created_at' => now()->subDays($i)
            ]);

            // Adicionar itens à venda
            $total = 0;
            $numItens = rand(1, 3);

            for ($j = 0; $j < $numItens; $j++) {
                $produto = $produtos->random();
                $quantidade = rand(1, 3);
                $precoUnitario = $produto->preco;
                $subtotal = $quantidade * $precoUnitario;
                $total += $subtotal;

                VendaItem::create([
                    'venda_id' => $venda->id,
                    'produto_id' => $produto->id,
                    'quantidade' => $quantidade,
                    'preco_unitario' => $precoUnitario,
                    'subtotal' => $subtotal
                ]);
            }

            // Atualizar o total da venda
            $venda->update(['total' => $total]);
        }
    }
}
