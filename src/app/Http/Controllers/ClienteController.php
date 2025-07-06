<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'status' => 'required|in:Ativo,Inativo'
        ]);
        $cliente = Cliente::create($request->all());
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Cliente criado com sucesso!', 'data' => $cliente]);
        }
        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso!');
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'status' => 'required|in:Ativo,Inativo'
        ]);
        $cliente->update($request->all());
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Cliente atualizado com sucesso!', 'data' => $cliente]);
        }
        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Cliente excluído com sucesso!']);
        }
        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }
}
