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
        Schema::create('mensagens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('texto')->nullable();
            $table->string('arquivo')->nullable();
            $table->boolean('lida')->default(false);
            $table->dateTime('data_leitura')->nullable();
            $table->dateTime('data_envio');

            $table->foreignUuid('user_id')
                ->index()
                ->constrained('users');
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
        Schema::dropIfExists('mensagens');
    }
};
