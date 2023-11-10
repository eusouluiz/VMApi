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
        Schema::create('cargo_funcionalidade', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('cargo_id')->constrained('cargos')->onDelete('cascade');
            $table->foreignUuid('funcionalidade_id')->constrained('funcionalidades')->onDelete('cascade');

            $table->unique(['cargo_id', 'funcionalidade_id']);
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo_funcionalidade');
    }
};
