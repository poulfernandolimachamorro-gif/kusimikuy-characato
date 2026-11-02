<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->string('concepto', 200); // Ej: Compra de papas, recarga de gas
            $table->decimal('monto', 10, 2);
            $table->enum('tipo_comprobante', ['Boleta', 'Factura', 'Recibo Interno']);
            $table->string('numero_comprobante', 50)->nullable();
            $table->date('fecha_gasto');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};