<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Classificacao;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with(['categoria', 'classificacao'])->get();
        $categorias = Categoria::where('status', 'Ativo')->get();
        $classificacoes = Classificacao::where('status', 'Ativo')->get();

        return view('produtos.index', compact('produtos', 'categorias', 'classificacoes'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'classificacao_id' => 'required|exists:classificacoes,id',
            'status' => 'required|in:Ativo,Inativo'
        ]);

        $produto = Produto::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Produto criado com sucesso!',
            'data' => $produto->load(['categoria', 'classificacao'])
        ]);
    }

    public function show(Produto $produto): JsonResponse
    {
        return response()->json($produto->load(['categoria', 'classificacao']));
    }

    public function edit($id)
    {
        return view('produtos.edit', compact('id'));
    }

    public function update(Request $request, Produto $produto): JsonResponse
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'classificacao_id' => 'required|exists:classificacoes,id',
            'status' => 'required|in:Ativo,Inativo'
        ]);

        $produto->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Produto atualizado com sucesso!',
            'data' => $produto->load(['categoria', 'classificacao'])
        ]);
    }

    public function destroy(Produto $produto): JsonResponse
    {
        $produto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produto excluído com sucesso!'
        ]);
    }
}
