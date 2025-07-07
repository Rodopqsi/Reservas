<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Para PostgreSQL, necesitamos usar SQL directo para modificar enums
        DB::statement("ALTER TABLE reservas DROP CONSTRAINT IF EXISTS reservas_estado_check");
        DB::statement("ALTER TABLE reservas ADD CONSTRAINT reservas_estado_check CHECK (estado IN ('pendiente', 'aprobada', 'rechazada', 'cancelada'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Volver al constraint original
        DB::statement("ALTER TABLE reservas DROP CONSTRAINT IF EXISTS reservas_estado_check");
        DB::statement("ALTER TABLE reservas ADD CONSTRAINT reservas_estado_check CHECK (estado IN ('pendiente', 'aprobada', 'rechazada'))");
    }
};
