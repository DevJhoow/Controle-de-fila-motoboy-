<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('motoboys', function (Blueprint $table) {
        $table->foreignId('restaurante_id')
              ->after('sobrenome')
              ->constrained()
              ->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::table('motoboys', function (Blueprint $table) {
        $table->dropForeign(['restaurante_id']);
        $table->dropColumn('restaurante_id');
    });
}

};
