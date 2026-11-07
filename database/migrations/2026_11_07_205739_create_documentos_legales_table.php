<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('documentos_legales', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_documento', ['Resolución Municipal', 'Registros Públicos', 'Libro de Actas Mensual']);
            $table->date('fecha_emision');
            $table->date('fecha_caducidad');
            $table->string('archivo_path', 255)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('documentos_legales'); }
};