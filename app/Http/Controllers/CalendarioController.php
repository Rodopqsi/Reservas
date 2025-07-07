<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aula;
use App\Models\Reserva;
use Carbon\Carbon;

class CalendarioController extends Controller
{    public function index(Request $request)
    {
        // Diagnóstico inicial
        if ($request->has('debug')) {
            return response()->json([
                'mensaje' => 'Controlador calendario funcionando',
                'datos' => [
                    'aula_id' => $request->get('aula_id'),
                    'fecha' => $request->get('fecha'),
                    'aulas_count' => Aula::count(),
                    'reservas_count' => Reserva::count(),
                ]
            ]);
        }
        
        try {
            $aulaId = $request->get('aula_id');
            $fecha = $request->get('fecha', now()->format('Y-m-d'));
            
            $aulas = Aula::where('activo', true)->get();
            
            // Debug: Verificar si hay aulas
            if ($aulas->isEmpty()) {
                return response('<h1>Debug: No hay aulas disponibles</h1><p>Aulas encontradas: ' . $aulas->count() . '</p><p>Total aulas: ' . Aula::count() . '</p>');
            }
            
            $aulaSeleccionada = $aulaId ? Aula::find($aulaId) : $aulas->first();
            
            if (!$aulaSeleccionada) {
                return response('<h1>Debug: No se pudo seleccionar aula</h1><p>Aula ID: ' . $aulaId . '</p><p>Aulas disponibles: ' . $aulas->count() . '</p>');
            }

            // Obtener la semana de la fecha seleccionada
            $fechaCarbon = Carbon::parse($fecha);
            $inicioSemana = $fechaCarbon->copy()->startOfWeek();
            $finSemana = $fechaCarbon->copy()->endOfWeek();
            
            // Obtener reservas de la semana para el aula seleccionada (incluyendo canceladas para mostrar)
            $reservas = Reserva::where('aula_id', $aulaSeleccionada->id)
                ->whereBetween('fecha', [$inicioSemana->format('Y-m-d'), $finSemana->format('Y-m-d')])
                ->whereIn('estado', ['aprobada', 'pendiente', 'cancelada'])
                ->with('user')
                ->orderBy('fecha')
                ->orderBy('hora_inicio')
                ->get();
            
            // Debug: Verificar reservas encontradas
            if ($request->has('debug_reservas')) {
                return response()->json([
                    'aula' => $aulaSeleccionada->nombre,
                    'periodo' => $inicioSemana->format('Y-m-d') . ' a ' . $finSemana->format('Y-m-d'),
                    'reservas_encontradas' => $reservas->count(),
                    'reservas' => $reservas->map(function($r) {
                        return [
                            'fecha' => $r->fecha,
                            'hora' => $r->hora_inicio . '-' . $r->hora_fin,
                            'profesor' => $r->user->name,
                            'estado' => $r->estado,
                            'motivo' => $r->motivo,
                            'observaciones' => $r->observaciones
                        ];
                    })
                ]);
            }
            
            // Generar horarios disponibles
            $horarios = $this->generarHorarios();
            $diasSemana = $this->generarDiasSemana($inicioSemana);
            
            // Verificar que todos los datos estén disponibles
            if (!$horarios || !$diasSemana) {
                return response('<h1>Debug: Error generando datos</h1><p>Horarios: ' . count($horarios) . '</p><p>Días: ' . count($diasSemana) . '</p>');
            }
            
            return view('calendario.index', compact(
                'aulas', 
                'aulaSeleccionada', 
                'reservas', 
                'horarios', 
                'diasSemana',
                'fechaCarbon'
            ));
            
        } catch (\Exception $e) {
            return response('<h1>Error en calendario</h1><p>Error: ' . $e->getMessage() . '</p><p>Archivo: ' . $e->getFile() . ':' . $e->getLine() . '</p><p>Trace: ' . $e->getTraceAsString() . '</p>');
        }
    }
    
    public function disponibilidad(Request $request)
    {
        $aulaId = $request->get('aula_id');
        $fecha = $request->get('fecha');
        $horaInicio = $request->get('hora_inicio');
        $horaFin = $request->get('hora_fin');
        
        $disponible = !Reserva::where('aula_id', $aulaId)
            ->where('fecha', $fecha)
            ->whereIn('estado', ['aprobada', 'pendiente'])
            ->where(function ($query) use ($horaInicio, $horaFin) {
                $query->whereBetween('hora_inicio', [$horaInicio, $horaFin])
                    ->orWhereBetween('hora_fin', [$horaInicio, $horaFin])
                    ->orWhere(function ($q) use ($horaInicio, $horaFin) {
                        $q->where('hora_inicio', '<=', $horaInicio)
                          ->where('hora_fin', '>=', $horaFin);
                    });
            })
            ->exists();
            
        return response()->json(['disponible' => $disponible]);
    }
    
    public function debug(Request $request)
    {
        $aulaId = $request->get('aula_id');
        $fecha = $request->get('fecha', now()->format('Y-m-d'));
        
        $aulas = Aula::where('activo', true)->get();
        $aulaSeleccionada = $aulaId ? Aula::find($aulaId) : $aulas->first();
        
        if (!$aulaSeleccionada) {
            $aulaSeleccionada = $aulas->first();
        }
        
        // Obtener la semana de la fecha seleccionada
        $fechaCarbon = Carbon::parse($fecha);
        $inicioSemana = $fechaCarbon->copy()->startOfWeek();
        $finSemana = $fechaCarbon->copy()->endOfWeek();
        
        // Obtener reservas de la semana para el aula seleccionada
        $reservas = collect();
        if ($aulaSeleccionada) {
            $reservas = Reserva::where('aula_id', $aulaSeleccionada->id)
                ->whereBetween('fecha', [$inicioSemana->format('Y-m-d'), $finSemana->format('Y-m-d')])
                ->whereIn('estado', ['aprobada', 'pendiente'])
                ->with('user')
                ->get();
        }
        
        // Generar horarios disponibles
        $horarios = $this->generarHorarios();
        $diasSemana = $this->generarDiasSemana($inicioSemana);
        
        return view('calendario.debug', compact(
            'aulas', 
            'aulaSeleccionada', 
            'reservas', 
            'horarios', 
            'diasSemana',
            'fechaCarbon'
        ));
    }
    
    public function simple(Request $request)
    {
        $aulaId = $request->get('aula_id');
        $fecha = $request->get('fecha', now()->format('Y-m-d'));
        
        $aulas = Aula::where('activo', true)->get();
        $aulaSeleccionada = $aulaId ? Aula::find($aulaId) : $aulas->first();
        
        if (!$aulaSeleccionada) {
            $aulaSeleccionada = $aulas->first();
        }
        
        // Obtener la semana de la fecha seleccionada
        $fechaCarbon = Carbon::parse($fecha);
        $inicioSemana = $fechaCarbon->copy()->startOfWeek();
        $finSemana = $fechaCarbon->copy()->endOfWeek();
        
        // Obtener reservas de la semana para el aula seleccionada
        $reservas = collect();
        if ($aulaSeleccionada) {
            $reservas = Reserva::where('aula_id', $aulaSeleccionada->id)
                ->whereBetween('fecha', [$inicioSemana->format('Y-m-d'), $finSemana->format('Y-m-d')])
                ->whereIn('estado', ['aprobada', 'pendiente'])
                ->with('user')
                ->get();
        }
        
        // Generar horarios disponibles
        $horarios = $this->generarHorarios();
        $diasSemana = $this->generarDiasSemana($inicioSemana);
        
        return view('calendario.simple', compact(
            'aulas', 
            'aulaSeleccionada', 
            'reservas', 
            'horarios', 
            'diasSemana',
            'fechaCarbon'
        ));
    }
    
    private function generarHorarios()
    {
        $horarios = [];
        
        // Generar horarios de 8:00 AM a 6:00 PM (horas normales)
        for ($hora = 8; $hora <= 18; $hora++) {
            $horaInicio = sprintf('%02d:00', $hora);
            $horaFin = sprintf('%02d:00', $hora + 1);
            
            // Convertir a formato de 12 horas para display
            $displayInicio = $hora <= 12 ? $hora . ':00 AM' : ($hora - 12) . ':00 PM';
            if ($hora == 12) $displayInicio = '12:00 PM';
            
            $displayFin = ($hora + 1) <= 12 ? ($hora + 1) . ':00 AM' : (($hora + 1) - 12) . ':00 PM';
            if (($hora + 1) == 12) $displayFin = '12:00 PM';
            if (($hora + 1) == 24) $displayFin = '12:00 AM';
            
            $horarios[] = [
                'inicio' => $horaInicio,
                'fin' => $horaFin,
                'display' => $displayInicio . ' - ' . $displayFin,
                'hora_numero' => $hora
            ];
        }
        
        return $horarios;
    }
    
    private function generarDiasSemana($inicioSemana)
    {
        $dias = [];
        for ($i = 0; $i < 7; $i++) {
            $dia = $inicioSemana->copy()->addDays($i);
            $dias[] = [
                'fecha' => $dia->format('Y-m-d'),
                'nombre' => $dia->format('l'),
                'numero' => $dia->format('d'),
                'mes' => $dia->format('M')
            ];
        }
        return $dias;
    }
    
    /**
     * Obtener datos del calendario para actualizaciones AJAX
     */
    public function obtenerDatos(Request $request)
    {
        $aulaId = $request->get('aula_id');
        $fecha = $request->get('fecha', now()->format('Y-m-d'));
        
        if (!$aulaId) {
            return response()->json(['error' => 'Aula no especificada'], 400);
        }
        
        $aulaSeleccionada = Aula::find($aulaId);
        if (!$aulaSeleccionada) {
            return response()->json(['error' => 'Aula no encontrada'], 404);
        }
        
        // Obtener la semana de la fecha seleccionada
        $fechaCarbon = Carbon::parse($fecha);
        $inicioSemana = $fechaCarbon->copy()->startOfWeek();
        $finSemana = $fechaCarbon->copy()->endOfWeek();
        
        // Obtener reservas de la semana para el aula seleccionada
        $reservas = Reserva::where('aula_id', $aulaSeleccionada->id)
            ->whereBetween('fecha', [$inicioSemana->format('Y-m-d'), $finSemana->format('Y-m-d')])
            ->whereIn('estado', ['aprobada', 'pendiente', 'cancelada'])
            ->with('user')
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();
            
        // Formatear reservas para AJAX
        $reservasFormateadas = $reservas->map(function($reserva) {
            // Asegurar que las horas sean solo tiempo, no datetime
            $horaInicio = $reserva->hora_inicio instanceof \Carbon\Carbon ? 
                $reserva->hora_inicio->format('H:i:s') : 
                (is_string($reserva->hora_inicio) ? $reserva->hora_inicio : date('H:i:s', strtotime($reserva->hora_inicio)));
                
            $horaFin = $reserva->hora_fin instanceof \Carbon\Carbon ? 
                $reserva->hora_fin->format('H:i:s') : 
                (is_string($reserva->hora_fin) ? $reserva->hora_fin : date('H:i:s', strtotime($reserva->hora_fin)));
                
            $fecha = $reserva->fecha instanceof \Carbon\Carbon ? 
                $reserva->fecha->format('Y-m-d') : 
                (is_string($reserva->fecha) ? $reserva->fecha : date('Y-m-d', strtotime($reserva->fecha)));
            
            return [
                'id' => $reserva->id,
                'fecha' => $fecha,
                'hora_inicio' => $horaInicio,
                'hora_fin' => $horaFin,
                'estado' => $reserva->estado,
                'profesor' => $reserva->user->name,
                'motivo' => $reserva->motivo,
                'observaciones' => $reserva->observaciones,
                'es_asignacion' => str_contains($reserva->observaciones ?? '', 'Asignación administrativa')
            ];
        });
        
        return response()->json([
            'success' => true,
            'reservas' => $reservasFormateadas,
            'aula' => [
                'id' => $aulaSeleccionada->id,
                'nombre' => $aulaSeleccionada->nombre,
                'codigo' => $aulaSeleccionada->codigo
            ],
            'periodo' => [
                'inicio' => $inicioSemana->format('Y-m-d'),
                'fin' => $finSemana->format('Y-m-d')
            ],
            'timestamp' => now()->timestamp
        ]);
    }
    
    public function obtenerDatosJson(Request $request)
    {
        $fecha = $request->get('fecha', now()->format('Y-m-d'));
        $aulaId = $request->get('aula');
        
        // Obtener aulas
        $aulasQuery = Aula::where('activo', true);
        if ($aulaId) {
            $aulasQuery->where('id', $aulaId);
        }
        $aulas = $aulasQuery->take(8)->get(); // Limitamos a 8 aulas para el home
        
        // Obtener reservas del día seleccionado (igual que el calendario principal)
        $reservasQuery = Reserva::where('fecha', $fecha)
            ->whereIn('estado', ['aprobada', 'pendiente', 'cancelada']) // Incluir todos los estados como el calendario principal
            ->with(['user', 'aula']);
            
        if ($aulaId) {
            $reservasQuery->where('aula_id', $aulaId);
        } else {
            // Solo reservas de las aulas que se muestran
            $reservasQuery->whereIn('aula_id', $aulas->pluck('id'));
        }
        
        $reservas = $reservasQuery->get();
        
        // Formatear datos para el calendario (usando la misma lógica que el servidor)
        $reservasFormateadas = [];
        foreach($reservas as $reserva) {
            $horaInicio = \Carbon\Carbon::parse($reserva->hora_inicio);
            $horaFin = \Carbon\Carbon::parse($reserva->hora_fin);
            
            // Generar slots para cada hora que abarca la reserva
            for ($hora = $horaInicio->hour; $hora < $horaFin->hour; $hora++) {
                $reservasFormateadas[] = [
                    'id' => $reserva->id,
                    'aula_id' => $reserva->aula_id,
                    'hora' => $hora,
                    'hora_inicio' => $horaInicio->format('H:i'),
                    'hora_fin' => $horaFin->format('H:i'),
                    'profesor_nombre' => $reserva->user->name,
                    'motivo' => $reserva->motivo,
                    'estado' => $reserva->estado,
                    'observaciones' => $reserva->observaciones,
                    'es_asignacion' => str_contains($reserva->observaciones ?? '', 'Asignación administrativa')
                ];
            }
        }
        
        return response()->json([
            'success' => true,
            'fecha' => $fecha,
            'aulas' => $aulas->map(function($aula) {
                return [
                    'id' => $aula->id,
                    'nombre' => $aula->nombre,
                    'codigo' => $aula->codigo
                ];
            }),
            'reservas' => $reservasFormateadas,
            'timestamp' => now()->timestamp
        ]);
    }
}
