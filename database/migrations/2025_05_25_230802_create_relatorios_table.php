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
        Schema::create('relatorios', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // 'vendas', 'devolucoes', 'estoque'
            $table->json('filtros'); // { periodo, categoria, etc }
            $table->json('dados');
            $table->foreignId('usuario_id')->constrained('users'); // trocar 'usuarios' para 'users'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relatorios');
    }
};
