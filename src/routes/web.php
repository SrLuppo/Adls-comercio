<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/layout-all', function () {
    return view('layout-all');
});

Route::get('/Home', function () {
    return view('index');
});
Route::get('/test-db-connection', function () {
    try {
        DB::connection()->getPdo();
        return "Conexão com o banco de dados bem-sucedida!";
    } catch (\Exception $e) {
        return "Não foi possível conectar ao banco de dados. Erro: " . $e->getMessage();
    }
});