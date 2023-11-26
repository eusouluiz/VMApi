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
        Schema::create('lembretes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('titulo')->nullable();
            $table->text('texto')->nullable();
            $table->dateTime('data_lembrete');

            $table->foreignUuid('aviso_id')
                ->index()
                ->unique()
                ->constrained('avisos')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembretes');
    }
};
