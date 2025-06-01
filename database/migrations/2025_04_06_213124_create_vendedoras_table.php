<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('vendedoras', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->string('email')->unique();
        $table->string('telefone');
        $table->decimal('comissao', 5, 2)->default(0.1); // 10% padrão
        $table->softDeletes();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    // Remover a foreign key da tabela vendas que referencia vendedoras
    Schema::table('vendas', function (Blueprint $table) {
        $table->dropForeign(['vendedora_id']);
    });

    // Agora pode apagar a tabela vendedoras
    Schema::dropIfExists('vendedoras');
}
};
