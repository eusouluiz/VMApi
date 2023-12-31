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
        Schema::create('avisos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('titulo');
            $table->text('texto')->nullable();
            $table->string('arquivo')->nullable();
            $table->dateTime('data_publicacao');
            $table->dateTime('data_expiracao')->nullable();
            $table->char('prioridade', 1)
                  ->default('2') 
                  ->check("prioridade IN ('1', '2', '3')");

            $table->foreignUuid('funcionario_id')
                ->index()
                ->constrained('funcionarios');
            $table->foreignUuid('canal_id')
                ->index()
                ->constrained('canais');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avisos');
    }
};
