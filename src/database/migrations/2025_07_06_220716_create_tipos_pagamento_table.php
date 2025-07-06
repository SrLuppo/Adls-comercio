<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('tipos_pagamento')) {
            Schema::create('tipos_pagamento', function (Blueprint $table) {
                $table->id();
                $table->string('nome');
                $table->string('descricao')->nullable();
                $table->enum('status', ['Ativo', 'Inativo'])->default('Ativo');
                $table->timestamps();
            });
        } else {
            // Se a tabela já existe, apenas adicionar as colunas que faltam
            Schema::table('tipos_pagamento', function (Blueprint $table) {
                if (!Schema::hasColumn('tipos_pagamento', 'nome')) {
                    $table->string('nome');
                }
                if (!Schema::hasColumn('tipos_pagamento', 'descricao')) {
                    $table->string('descricao')->nullable();
                }
                if (!Schema::hasColumn('tipos_pagamento', 'status')) {
                    $table->enum('status', ['Ativo', 'Inativo'])->default('Ativo');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_pagamento');
    }
};
