<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Criar tabela vendas se não existir
        if (!Schema::hasTable('vendas')) {
            Schema::create('vendas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('cliente_id')->constrained('clientes')->onDelete('restrict');
                $table->foreignId('usuario_id')->constrained('users')->onDelete('restrict');
                $table->decimal('total', 10, 2);
                $table->enum('forma_pagamento', ['dinheiro', 'cartao', 'pix']);
                $table->text('observacoes')->nullable();
                $table->enum('status', ['Concluida', 'Cancelada'])->default('Concluida');
                $table->timestamps();
            });
        }

        // Criar tabela venda_items se não existir
        if (!Schema::hasTable('venda_items')) {
            Schema::create('venda_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('venda_id')->constrained('vendas')->onDelete('cascade');
                $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
                $table->integer('quantidade');
                $table->decimal('preco_unitario', 10, 2);
                $table->decimal('subtotal', 10, 2);
                $table->timestamps();
            });
        }

        // Adicionar coluna código na tabela produtos se não existir
        if (!Schema::hasColumn('produtos', 'codigo')) {
            Schema::table('produtos', function (Blueprint $table) {
                $table->string('codigo')->unique()->after('id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('venda_items');
        Schema::dropIfExists('vendas');

        if (Schema::hasColumn('produtos', 'codigo')) {
            Schema::table('produtos', function (Blueprint $table) {
                $table->dropColumn('codigo');
            });
        }
    }
};
