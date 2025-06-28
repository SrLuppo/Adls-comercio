<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;

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

// Rotas de autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/index', [AuthController::class, 'Home'])->name('Home');
});

// Route::get('/Home', function () {
//     return view('index');
// });

// Route::get('/layout-all', function () {
//     return view('layout-all');
// });
// Route::get('/test-db-connection', function () {
//     try {
//         DB::connection()->getPdo();
//         return "Conexão com o banco de dados bem-sucedida!";
//     } catch (\Exception $e) {
//         return "Não foi possível conectar ao banco de dados. Erro: " . $e->getMessage();
//     }
// });
