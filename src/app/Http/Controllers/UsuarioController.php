<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'perfil' => 'required|in:Administrador,Vendedor,Estoquista',
            'status' => 'required|in:Ativo,Inativo',
            'observacoes' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $usuario = User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Usuário criado com sucesso!',
            'data' => $usuario
        ]);
    }

    public function show(User $usuario): JsonResponse
    {
        return response()->json($usuario);
    }

    public function edit($id)
    {
        return view('usuarios.edit', compact('id'));
    }

    public function update(Request $request, User $usuario): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'perfil' => 'required|in:Administrador,Vendedor,Estoquista',
            'status' => 'required|in:Ativo,Inativo',
            'observacoes' => 'nullable|string'
        ]);

        $data = $request->except(['password', 'password_confirmation']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Usuário atualizado com sucesso!',
            'data' => $usuario
        ]);
    }

    public function destroy(User $usuario): JsonResponse
    {
        $usuario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuário excluído com sucesso!'
        ]);
    }
}
