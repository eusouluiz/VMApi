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
        Schema::create('canal_responsavel', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('canal_id')->constrained('canais')->onDelete('cascade');
            $table->foreignUuid('responsavel_id')->constrained('responsaveis')->onDelete('cascade');

            $table->unique(['canal_id', 'responsavel_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canal_responsavel');
    }
};
