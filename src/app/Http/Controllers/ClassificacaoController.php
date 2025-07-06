<?php

namespace App\Http\Controllers;

use App\Models\Classificacao;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClassificacaoController extends Controller
{
    public function index()
    {
        $classificacoes = Classificacao::all();
        return view('classificacoes.index', compact('classificacoes'));
    }

    public function create()
    {
        return view('classificacoes.create');
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|in:Ativo,Inativo'
        ]);

        $classificacao = Classificacao::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Classificação criada com sucesso!',
            'data' => $classificacao
        ]);
    }

    public function edit($id)
    {
        return view('classificacoes.edit', compact('id'));
    }

    public function show(Classificacao $classificacao): JsonResponse
    {
        return response()->json($classificacao);
    }

    public function update(Request $request, Classificacao $classificacao): JsonResponse
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|in:Ativo,Inativo'
        ]);

        $classificacao->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Classificação atualizada com sucesso!',
            'data' => $classificacao
        ]);
    }

    public function destroy(Classificacao $classificacao): JsonResponse
    {
        $classificacao->delete();

        return response()->json([
            'success' => true,
            'message' => 'Classificação excluída com sucesso!'
        ]);
    }
}
