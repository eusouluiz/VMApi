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
            $table->text('texto')->nullable();
            $table->string('arquivo')->nullable();
            $table->date('data_publicacao');
            $table->date('data_expiracao')->nullable();
            $table->string('prioridade')->default('normal');

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
