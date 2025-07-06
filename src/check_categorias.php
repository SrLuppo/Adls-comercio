<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Categoria;

$count = Categoria::count();
echo "Total de categorias: " . $count . "\n";

if ($count > 0) {
    $categorias = Categoria::all();
    foreach ($categorias as $categoria) {
        echo "ID: {$categoria->id}, Nome: {$categoria->nome}, Status: {$categoria->status}\n";
    }
} else {
    echo "Nenhuma categoria encontrada.\n";
}
