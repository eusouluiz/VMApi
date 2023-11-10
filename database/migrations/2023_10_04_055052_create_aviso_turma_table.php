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
        Schema::create('aviso_turma', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('aviso_id')->constrained('avisos')->onDelete('cascade');
            $table->foreignUuid('turma_id')->constrained('turmas')->onDelete('cascade');

            $table->unique(['aviso_id', 'turma_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aviso_turma');
    }
};
