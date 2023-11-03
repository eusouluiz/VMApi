<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aviso_responsavel', function (Blueprint $table) {
            $table->foreignUuid('aviso_id')->constrained('avisos')->onDelete('cascade');
            $table->foreignUuid('responsavel_id')->constrained('responsaveis')->onDelete('cascade');
            $table->boolean('ind_visualizacao')->default(false);

            $table->unique(['aviso_id', 'responsavel_id']);
            $table->primary(['aviso_id', 'responsavel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aviso_responsavel');
    }
};
