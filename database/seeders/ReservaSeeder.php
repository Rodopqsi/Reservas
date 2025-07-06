<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Aula;
use App\Http\Controllers\NotificacionController;

class ReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profesores = User::where('role', 'profesor')->get();
        $aulas = Aula::all();
        
        if ($profesores->isEmpty() || $aulas->isEmpty()) {
            return;
        }

        // Crear algunas reservas de ejemplo
        $reservas = [
            [
                'user_id' => $profesores->first()->id,
                'aula_id' => $aulas->first()->id,
                'fecha' => now()->addDays(1)->format('Y-m-d'),
                'hora_inicio' => '09:00',
                'hora_fin' => '10:00',
                'motivo' => 'Clase de Matemáticas',
                'observaciones' => 'Necesito proyector',
                'estado' => 'pendiente',
            ],
            [
                'user_id' => $profesores->skip(1)->first()->id,
                'aula_id' => $aulas->skip(1)->first()->id,
                'fecha' => now()->addDays(2)->format('Y-m-d'),
                'hora_inicio' => '14:00',
                'hora_fin' => '15:00',
                'motivo' => 'Seminario de Física',
                'observaciones' => null,
                'estado' => 'pendiente',
            ],
            [
                'user_id' => $profesores->skip(2)->first()->id,
                'aula_id' => $aulas->skip(2)->first()->id,
                'fecha' => now()->addDays(3)->format('Y-m-d'),
                'hora_inicio' => '11:00',
                'hora_fin' => '12:00',
                'motivo' => 'Examen Final',
                'observaciones' => 'Requiere silencio absoluto',
                'estado' => 'aprobada',
            ],
        ];

        foreach ($reservas as $reservaData) {
            $reserva = Reserva::create($reservaData);
            
            // Crear notificaciones para administradores si la reserva está pendiente
            if ($reserva->estado === 'pendiente') {
                NotificacionController::crearNotificacionAdmin($reserva, 'nueva_reserva');
            }
        }
    }
}
