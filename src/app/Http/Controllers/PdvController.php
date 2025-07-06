<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Produto;
use App\Models\TipoPagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Venda;
use App\Models\VendaItem;

class PdvController extends Controller
{
    public function index()
    {
        $clientes = Cliente::where('status', 'Ativo')->get();
        $produtos = Produto::where('status', 'Ativo')->get();
        $tiposPagamento = TipoPagamento::where('status', 'Ativo')->get();
        return view('pdv.index', compact('clientes', 'produtos', 'tiposPagamento'));
    }

    public function buscarProduto(Request $request)
    {
        $codigo = $request->input('codigo');
        $produto = Produto::where(function ($query) use ($codigo) {
            $query->where('codigo', 'LIKE', "%{$codigo}%")
                ->orWhere('nome', 'LIKE', "%{$codigo}%");
        })
            ->where('status', 'Ativo')
            ->first();

        if ($produto) {
            return response()->json([
                'success' => true,
                'produto' => $produto
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produto não encontrado'
        ]);
    }

    public function finalizarVenda(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'itens' => 'required|array|min:1',
            'itens.*.produto_id' => 'required|exists:produtos,id',
            'itens.*.quantidade' => 'required|integer|min:1',
            'itens.*.preco_unitario' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'tipo_pagamento_id' => 'required|exists:tipos_pagamento,id',
            'observacoes' => 'nullable|string'
        ]);

        try {
            // Criar a venda
            $venda = Venda::create([
                'cliente_id' => $request->cliente_id,
                'usuario_id' => $request->user()->id,
                'total' => $request->total,
                'tipo_pagamento_id' => $request->tipo_pagamento_id,
                'observacoes' => $request->observacoes,
                'status' => 'Concluida'
            ]);

            // Criar os itens da venda
            foreach ($request->itens as $item) {
                VendaItem::create([
                    'venda_id' => $venda->id,
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $item['preco_unitario'],
                    'subtotal' => $item['quantidade'] * $item['preco_unitario']
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Venda finalizada com sucesso!',
                'venda_id' => $venda->id
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao finalizar venda: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::error('Dados da requisição: ' . json_encode($request->all()));

            return response()->json([
                'success' => false,
                'message' => 'Erro ao finalizar venda: ' . $e->getMessage()
            ], 500);
        }
    }
}
