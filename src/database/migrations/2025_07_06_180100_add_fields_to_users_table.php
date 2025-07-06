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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('perfil', ['Administrador', 'Vendedor', 'Estoquista'])->default('Vendedor')->after('email');
            $table->enum('status', ['Ativo', 'Inativo'])->default('Ativo')->after('perfil');
            $table->text('observacoes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['perfil', 'status', 'observacoes']);
        });
    }
};
