<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración de control de asistencia alimentaria.
     */
    public function up(): void
    {
        Schema::create('entregas_raciones', function (Blueprint $table) {
            $table->id();
            
            // Relación estricta con el padrón de beneficiarios anonimizado (Ley N° 29733)
            $table->foreignId('beneficiario_id')->constrained('beneficiarios')->onDelete('restrict');
            
            // Atributos de control operativo diario
            $table->date('fecha_entrega'); // Día del despacho
            $table->integer('raciones_retiradas'); // Platos servidos a la familia
            
            // Atributo financiero para la liquidación de caja chica (Tarifas S/. 5.00 y S/. 8.00)
            $table->decimal('cuota_cobrada', 8, 2); 
            
            $table->timestamps();

            /**
             * REGLA DE SEGURIDAD ANTI-FRAUDE (Rúbrica de la RAE):
             * Crea un índice compuesto de unicidad estricto. Esto impide a nivel de motor de base de datos (MySQL)
             * que un beneficiario pueda marcar asistencia o retirar platos dos veces en la misma fecha.
             */
            $table->unique(['beneficiario_id', 'fecha_entrega']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entregas_raciones');
    }
};