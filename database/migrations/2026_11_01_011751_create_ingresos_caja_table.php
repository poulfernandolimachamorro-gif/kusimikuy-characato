<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ingresos_caja', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_ingreso', ['Cuotas Diarias', 'Subsidio Municipal', 'Donación Efectivo']);
            $table->decimal('monto', 10, 2);
            $table->date('fecha_ingreso');
            $table->foreignId('entrega_id')->nullable()->constrained('entregas_raciones')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingresos_caja');
    }
};