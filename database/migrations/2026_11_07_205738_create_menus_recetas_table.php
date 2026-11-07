<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('menus_recetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_plato', 150);
            $table->foreignId('insumo_id')->constrained('insumos')->onDelete('cascade');
            $table->decimal('gramos_por_racion', 6, 2);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('menus_recetas'); }
};