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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id(); // Coluna ID (chave primária)
            $table->string('nome'); // Nome do produto
            $table->text('descricao')->nullable(); // Descrição do produto (opcional)
            $table->decimal('preco', 8, 2); // Preço do produto (8 dígitos no total, 2 casas decimais)
            $table->integer('quantidade'); // Quantidade em estoque
            $table->string('numeracao')->nullable();
            $table->string('cor')->nullable();
            $table->string('marca')->nullable();
            $table->integer('estoque')->default(0);
            $table->timestamps(); // Colunas created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos'); // Remove a tabela se a migration for revertida
    }
};