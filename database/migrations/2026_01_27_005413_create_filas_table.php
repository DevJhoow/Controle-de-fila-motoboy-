<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('filas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('motoboy_id')->constrained()->onDelete('cascade');
            $table->foreignId('restaurante_id')->constrained()->onDelete('cascade');

            $table->integer('posicao');
            $table->boolean('ativo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filas');
    }
};
