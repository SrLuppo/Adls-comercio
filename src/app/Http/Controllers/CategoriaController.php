<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|in:Ativo,Inativo'
        ]);

        $categoria = Categoria::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Categoria criada com sucesso!',
                'data' => $categoria
            ]);
        }
        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function show(Categoria $categoria): JsonResponse
    {
        return response()->json($categoria);
    }

    public function edit($id)
    {
        return view('categorias.edit', compact('id'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        Log::info('Update categoria', [
            'url_id' => $categoria->id,
            'request_id' => $request->id,
            'all' => $request->all()
        ]);

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|in:Ativo,Inativo'
        ]);

        $categoria->update($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Categoria atualizada com sucesso!',
                'data' => $categoria
            ]);
        }
        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Categoria excluída com sucesso!'
            ]);
        }
        return redirect()->route('categorias.index')->with('success', 'Categoria excluída com sucesso!');
    }
}
 