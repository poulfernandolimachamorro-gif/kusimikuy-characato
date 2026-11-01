<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_insumo', 100);
            $table->decimal('stock_actual', 10, 2)->default(0);
            $table->decimal('stock_minimo_alerta', 10, 2)->default(0);
            $table->decimal('limite_consumo_diario', 10, 2)->nullable();
            $table->enum('unidad_medida', ['Kilogramos', 'Litros', 'Unidades', 'Sacos']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};