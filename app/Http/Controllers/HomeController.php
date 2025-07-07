<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aula;
use App\Models\Reserva;

class HomeController extends Controller
{
    public function index()
    {
        $aulas = Aula::where('activo', true)->get();
        
        // Reservas del usuario para la sección "Mis Reservas Recientes"
        $misReservas = Reserva::with(['aula', 'user'])
            ->where('user_id', auth()->id())
            ->orderBy('fecha', 'desc')
            ->take(5)
            ->get();
            
        // TODAS las reservas del día actual para el calendario - usar la misma lógica que el calendario principal
        $reservasHoy = Reserva::with(['aula', 'user'])
            ->where('fecha', today()->format('Y-m-d'))
            ->whereIn('estado', ['aprobada', 'pendiente', 'cancelada']) // Incluir todos los estados como el calendario principal
            ->orderBy('hora_inicio')
            ->get();
            
        // Todas las reservas para estadísticas
        $todasLasReservas = Reserva::all();
            
        return view('home', [
            'aulas' => $aulas,
            'reservas' => $misReservas, // Para la sección "Mis Reservas"
            'reservasCalendario' => $reservasHoy, // Para el calendario
            'todasLasReservas' => $todasLasReservas // Para estadísticas
        ]);
    }
}
