<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lotes_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insumo_id')->constrained('insumos')->onDelete('cascade');
            $table->string('codigo_lote', 50);
            $table->date('fecha_vencimiento')->nullable();
            $table->enum('estado_calidad', ['Óptimo', 'Defectuoso/Verde', 'Mermado'])->default('Óptimo');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('lotes_inventario'); }
};