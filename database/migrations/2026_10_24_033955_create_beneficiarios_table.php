<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('beneficiarios', function (Blueprint $table) {
            $table->id();
            // Código anonimizado solicitado para cumplimiento perimetral de la Ley N° 29733 (Ej: BEN-CHA-001)
            $table->string('codigo_beneficiario', 20)->unique(); 
            // Enum estricto para sustentar las tarifas sociales diferenciadas de S/. 5 y S/. 8 en caja
            $table->enum('tipo_comensal', ['Socio/Cocinera', 'Público General']); 
            $table->integer('cantidad_integrantes');
            $table->integer('raciones_asignadas');
            $table->date('fecha_incorporacion');
            $table->boolean('estado')->default(true);
            
            // Trait nativo SoftDeletes solicitado por la rúbrica para bajas lógicas
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiarios');
    }
};
