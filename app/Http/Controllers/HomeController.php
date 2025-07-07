<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aula;
use App\Models\Reserva;
use Carbon\Carbon;

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
            
        // TODAS las reservas de la semana actual para el calendario - usar la misma lógica que el calendario principal
        $startOfWeek = today()->startOfWeek();
        $endOfWeek = today()->endOfWeek();
        
        $reservasSemana = Reserva::with(['aula', 'user'])
            ->whereBetween('fecha', [$startOfWeek, $endOfWeek])
            ->whereIn('estado', ['aprobada', 'pendiente', 'cancelada']) // Incluir todos los estados como el calendario principal
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();
            
        // Todas las reservas para estadísticas
        $todasLasReservas = Reserva::all();
        
        // Estadísticas para el panel lateral
        $totalReservas = $todasLasReservas->count();
        $reservasConfirmadas = $todasLasReservas->where('estado', 'aprobada')->count();
        $reservasPendientes = $todasLasReservas->where('estado', 'pendiente')->count();
        
        // Generar array de días de la semana para el frontend
        $diasSemana = [];
        for ($i = 0; $i < 7; $i++) {
            $fecha = $startOfWeek->copy()->addDays($i);
            $diasSemana[] = [
                'fecha' => $fecha->format('Y-m-d'),
                'dia' => $fecha->format('d'),
                'mes' => $fecha->format('M'),
                'diaSemana' => $fecha->format('D'),
                'esHoy' => $fecha->isToday()
            ];
        }
            
        return view('home', [
            'aulas' => $aulas,
            'reservas' => $misReservas, // Para la sección "Mis Reservas"
            'reservasCalendario' => $reservasSemana, // Para el calendario
            'todasLasReservas' => $todasLasReservas, // Para estadísticas
            'diasSemana' => $diasSemana, // Para mostrar los días de la semana
            'totalReservas' => $totalReservas,
            'reservasConfirmadas' => $reservasConfirmadas,
            'reservasPendientes' => $reservasPendientes
        ]);
    }
}
