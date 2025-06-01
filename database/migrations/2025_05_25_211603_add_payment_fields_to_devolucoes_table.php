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
        Schema::table('devolucoes', function (Blueprint $table) {
            $table->string('metodo_estorno')->nullable();
            $table->string('codigo_transacao')->nullable();
            $table->boolean('notificado')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devolucoes', function (Blueprint $table) {
            //
        });
    }
};
