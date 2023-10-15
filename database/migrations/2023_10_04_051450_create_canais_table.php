<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('canais', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nome');
            $table->string('descricao');

            $table->foreignUuid('aluno_id')
                ->index()
                ->constrained('alunos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canais');
    }
};