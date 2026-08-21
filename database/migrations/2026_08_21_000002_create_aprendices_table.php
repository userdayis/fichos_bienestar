<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aprendices', function (Blueprint $table) {
            $table->id();
            $table->string('documento', 20)->unique();
            $table->string('nombre', 150);
            $table->string('correo', 150)->nullable();
            $table->string('ficha', 30)->nullable();
            $table->timestamps();

            $table->index('documento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aprendices');
    }
};
