<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Classificacao;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Criar categorias
        Categoria::create([
            'nome' => 'Eletrônicos',
            'descricao' => 'Produtos eletrônicos e tecnológicos',
            'status' => 'Ativo'
        ]);

        Categoria::create([
            'nome' => 'Vestuário',
            'descricao' => 'Roupas e acessórios',
            'status' => 'Ativo'
        ]);

        Categoria::create([
            'nome' => 'Casa e Jardim',
            'descricao' => 'Produtos para casa e jardinagem',
            'status' => 'Inativo'
        ]);

        // Criar classificações
        Classificacao::create([
            'nome' => 'Premium',
            'descricao' => 'Produtos de alta qualidade',
            'status' => 'Ativo'
        ]);

        Classificacao::create([
            'nome' => 'Standard',
            'descricao' => 'Produtos de qualidade padrão',
            'status' => 'Ativo'
        ]);

        Classificacao::create([
            'nome' => 'Econômico',
            'descricao' => 'Produtos de baixo custo',
            'status' => 'Inativo'
        ]);

        // Criar produtos
        $categoriaEletronicos = Categoria::where('nome', 'Eletrônicos')->first();
        $categoriaVestuario = Categoria::where('nome', 'Vestuário')->first();
        $categoriaCasa = Categoria::where('nome', 'Casa e Jardim')->first();

        $classificacaoPremium = Classificacao::where('nome', 'Premium')->first();
        $classificacaoStandard = Classificacao::where('nome', 'Standard')->first();
        $classificacaoEconomico = Classificacao::where('nome', 'Econômico')->first();

        Produto::create([
            'nome' => 'Smartphone Galaxy S21',
            'descricao' => 'Smartphone Samsung Galaxy S21 com 128GB',
            'preco' => 2999.00,
            'categoria_id' => $categoriaEletronicos->id,
            'classificacao_id' => $classificacaoPremium->id,
            'status' => 'Ativo'
        ]);

        Produto::create([
            'nome' => 'Camiseta Básica',
            'descricao' => 'Camiseta básica de algodão',
            'preco' => 49.90,
            'categoria_id' => $categoriaVestuario->id,
            'classificacao_id' => $classificacaoStandard->id,
            'status' => 'Ativo'
        ]);

        Produto::create([
            'nome' => 'Vaso de Plástico',
            'descricao' => 'Vaso de plástico para plantas',
            'preco' => 15.50,
            'categoria_id' => $categoriaCasa->id,
            'classificacao_id' => $classificacaoEconomico->id,
            'status' => 'Ativo'
        ]);

        Produto::create([
            'nome' => 'Notebook Dell Inspiron',
            'descricao' => 'Notebook Dell Inspiron 15 polegadas',
            'preco' => 4500.00,
            'categoria_id' => $categoriaEletronicos->id,
            'classificacao_id' => $classificacaoPremium->id,
            'status' => 'Inativo'
        ]);

        // Criar usuários
        User::create([
            'name' => 'João Silva',
            'email' => 'joao@email.com',
            'password' => Hash::make('12345678'),
            'perfil' => 'Administrador',
            'status' => 'Ativo',
            'observacoes' => 'Usuário administrador do sistema'
        ]);

        User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@email.com',
            'password' => Hash::make('12345678'),
            'perfil' => 'Vendedor',
            'status' => 'Ativo',
            'observacoes' => 'Vendedora responsável pela loja'
        ]);

        User::create([
            'name' => 'Pedro Costa',
            'email' => 'pedro@email.com',
            'password' => Hash::make('12345678'),
            'perfil' => 'Estoquista',
            'status' => 'Inativo',
            'observacoes' => 'Estoquista temporário'
        ]);
    }
}
