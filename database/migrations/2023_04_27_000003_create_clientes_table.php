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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('data_nascimento');
            $table->string('cpf')->unique();
            $table->unsignedBigInteger('endereco_id');
            $table->unsignedBigInteger('contato_id');
            $table->timestamps();

            $table->foreign('endereco_id')->references('id')->on('enderecos');
            $table->foreign('contato_id')->references('id')->on('contatos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
