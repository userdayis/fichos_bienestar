<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'operador'])->default('operador')->after('email');
            $table->foreignId('actividad_id')->nullable()->after('role')->constrained('actividades')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['actividad_id']);
            $table->dropColumn(['role', 'actividad_id']);
        });
    }
};
