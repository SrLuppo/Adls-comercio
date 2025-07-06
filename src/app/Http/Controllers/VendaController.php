<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\VendaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class VendaController extends Controller
{
    public function index()
    {
        try {
            // Usar uma query mais simples para evitar problemas com foreign keys
            $vendas = Venda::select('vendas.*')
                ->leftJoin('clientes', 'vendas.cliente_id', '=', 'clientes.id')
                ->leftJoin('users', 'vendas.usuario_id', '=', 'users.id')
                ->leftJoin('tipos_pagamento', 'vendas.tipo_pagamento_id', '=', 'tipos_pagamento.id')
                ->orderBy('vendas.created_at', 'desc')
                ->get();

            // Carregar relacionamentos manualmente para evitar problemas
            foreach ($vendas as $venda) {
                $venda->load(['cliente', 'usuario', 'tipoPagamento', 'itens.produto']);
            }

            return view('vendas.index', compact('vendas'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar vendas: ' . $e->getMessage());
            return view('vendas.index', ['vendas' => collect()])->with('error', 'Erro ao carregar vendas: ' . $e->getMessage());
        }
    }

    public function show(Venda $venda)
    {
        $venda->load(['cliente', 'usuario', 'tipoPagamento', 'itens.produto']);
        return response()->json($venda);
    }

    public function destroy(Request $request, Venda $venda)
    {
        $request->validate([
            'senha_admin' => 'required|string'
        ]);

        // Verificar se a senha do admin está correta
        $senhaAdmin = 'admin123'; // Senha padrão fixa

        if (!Hash::check($request->senha_admin, Hash::make($senhaAdmin))) {
            return response()->json([
                'success' => false,
                'message' => 'Senha de administrador incorreta!'
            ], 403);
        }

        try {
            // Excluir itens da venda primeiro
            $venda->itens()->delete();

            // Excluir a venda
            $venda->delete();

            return response()->json([
                'success' => true,
                'message' => 'Venda excluída com sucesso!'
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao excluir venda: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir venda. Tente novamente.'
            ], 500);
        }
    }
}
