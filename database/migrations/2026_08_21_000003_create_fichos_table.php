<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fichos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aprendiz_id')->constrained('aprendices')->cascadeOnDelete();
            $table->foreignId('actividad_id')->constrained('actividades')->cascadeOnDelete();
            $table->string('codigo_qr', 36)->unique(); // UUID
            $table->string('codigo_respaldo', 8)->unique(); // e.g. "X3K-M9P2"
            $table->enum('estado', ['pendiente', 'entregado'])->default('pendiente');
            $table->timestamp('entregado_en')->nullable();
            $table->foreignId('entregado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Garantiza un solo ficho por aprendiz por actividad
            $table->unique(['aprendiz_id', 'actividad_id'], 'fichos_aprendiz_actividad_unique');
            $table->index('estado');
            $table->index('codigo_qr');
            $table->index('codigo_respaldo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fichos');
    }
};
