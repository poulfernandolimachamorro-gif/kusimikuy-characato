<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración de almacén e inventarios.
     */
    public function up(): void
    {
        Schema::create('movimientos_kardex', function (Blueprint $table) {
            $table->id();
            
            // Relaciones relacionales estrictas
            $table->foreignId('beneficiario_id')->nullable()->constrained('beneficiarios')->onDelete('restrict');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('restrict'); // Quién operó
            
            // Atributos de micro-gestión diaria y control de raciones
            $table->enum('tipo_movimiento', [
                'Entrada - Municipal', 
                'Entrada - Donación', 
                'Salida - Cocina', 
                'Salida - Merma Insumo Verde'
            ]);
            
            // Atributo con precisión matemática para el pesaje estricto de kilogramos
            $table->decimal('cantidad_kg', 10, 2); 
            $table->string('motivo_detalle', 200)->nullable(); // Ej: "Consumo diario cocina o merma de arroz"
            
            // Bitácora inmutable de solo inserción para auditorías de la MPA
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     * REGLA DE AUDITORÍA: El historial de Kardex es inmutable por norma de la MPA; 
     * por ende, se bloquea el borrado destructivo de la estructura física en producción.
     */
    public function down(): void
    {
        // Bloqueado con fines de cumplimiento y transparencia
    }
};