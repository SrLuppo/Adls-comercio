<?php

namespace App\Http\Controllers;

use App\Models\TipoPagamento;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TipoPagamentoController extends Controller
{
    public function index()
    {
        $tiposPagamento = TipoPagamento::orderBy('nome')->get();
        return view('tipos-pagamento.index', compact('tiposPagamento'));
    }

    public function create()
    {
        return view('tipos-pagamento.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:255',
            'status' => 'required|in:Ativo,Inativo'
        ]);

        $tipoPagamento = TipoPagamento::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tipo de pagamento criado com sucesso!',
                'data' => $tipoPagamento
            ]);
        }
        return redirect()->route('tipos-pagamento.index')->with('success', 'Tipo de pagamento criado com sucesso!');
    }

    public function show(TipoPagamento $tipoPagamento): JsonResponse
    {
        return response()->json($tipoPagamento);
    }

    public function edit($id)
    {
        return view('tipos-pagamento.edit', compact('id'));
    }

    public function update(Request $request, TipoPagamento $tipoPagamento)
    {
        Log::info('Update tipo pagamento', [
            'url_id' => $tipoPagamento->id,
            'request_id' => $request->id,
            'all' => $request->all()
        ]);

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:255',
            'status' => 'required|in:Ativo,Inativo'
        ]);

        $tipoPagamento->update($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tipo de pagamento atualizado com sucesso!',
                'data' => $tipoPagamento
            ]);
        }
        return redirect()->route('tipos-pagamento.index')->with('success', 'Tipo de pagamento atualizado com sucesso!');
    }

    public function destroy(TipoPagamento $tipoPagamento)
    {
        $tipoPagamento->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tipo de pagamento excluído com sucesso!'
            ]);
        }
        return redirect()->route('tipos-pagamento.index')->with('success', 'Tipo de pagamento excluído com sucesso!');
    }
}
