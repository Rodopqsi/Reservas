<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Aula;
use App\Models\User;
use App\Http\Controllers\NotificacionController;
use Carbon\Carbon;

class AsignacionController extends Controller
{
    /**
     * Mostrar formulario de asignación
     */
    public function index()
    {
        $aulas = Aula::where('activo', true)->get();
        $profesores = User::where('role', 'profesor')->get();
        
        return view('admin.asignaciones.index', compact('aulas', 'profesores'));
    }

    /**
     * Crear asignación masiva de horarios
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'aula_id' => 'required|exists:aulas,id',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'dias_semana' => 'required|array|min:1',
            'dias_semana.*' => 'in:1,2,3,4,5,6,7', // 1=Lunes, 7=Domingo
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'motivo' => 'required|string|max:255',
            'observaciones' => 'nullable|string|max:500'
        ]);

        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);
        $diasSemana = $request->dias_semana;
        
        // Validar que el usuario sea profesor
        $profesor = User::find($request->user_id);
        if ($profesor->role !== 'profesor') {
            return redirect()->back()
                ->withErrors(['user_id' => 'Solo se pueden asignar horarios a profesores.'])
                ->withInput();
        }

        // Validar que el aula esté activa
        $aula = Aula::find($request->aula_id);
        if (!$aula->activo) {
            return redirect()->back()
                ->withErrors(['aula_id' => 'El aula seleccionada no está activa.'])
                ->withInput();
        }

        // Calcular el número total de reservas que se van a crear
        $totalDias = 0;
        for ($fecha = $fechaInicio->copy(); $fecha->lte($fechaFin); $fecha->addDay()) {
            if (in_array($fecha->dayOfWeek == 0 ? 7 : $fecha->dayOfWeek, $diasSemana)) {
                $totalDias++;
            }
        }

        // Limitar el número de reservas para evitar sobrecarga
        if ($totalDias > 100) {
            return redirect()->back()
                ->withErrors(['fecha_fin' => 'El rango de fechas resulta en demasiadas reservas (' . $totalDias . '). Por favor, reduzca el período.'])
                ->withInput();
        }
        
        $reservasCreadas = 0;
        $conflictos = [];
        
        // Recorrer cada día en el rango
        for ($fecha = $fechaInicio->copy(); $fecha->lte($fechaFin); $fecha->addDay()) {
            // Verificar si el día está en los días seleccionados
            if (in_array($fecha->dayOfWeek == 0 ? 7 : $fecha->dayOfWeek, $diasSemana)) {
                
                // Verificar conflictos
                $conflicto = Reserva::where('aula_id', $request->aula_id)
                    ->where('fecha', $fecha->format('Y-m-d'))
                    ->whereIn('estado', ['aprobada', 'pendiente'])
                    ->where(function ($query) use ($request) {
                        $query->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                            ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin])
                            ->orWhere(function ($q) use ($request) {
                                $q->where('hora_inicio', '<=', $request->hora_inicio)
                                  ->where('hora_fin', '>=', $request->hora_fin);
                            });
                    })
                    ->exists();
                
                if ($conflicto) {
                    $conflictos[] = $fecha->format('d/m/Y');
                } else {
                    // Crear la reserva
                    $reserva = Reserva::create([
                        'user_id' => $request->user_id,
                        'aula_id' => $request->aula_id,
                        'fecha' => $fecha->format('Y-m-d'),
                        'hora_inicio' => $request->hora_inicio,
                        'hora_fin' => $request->hora_fin,
                        'motivo' => $request->motivo,
                        'observaciones' => ($request->observaciones ? $request->observaciones . ' ' : '') . '(Asignación administrativa)',
                        'estado' => 'aprobada' // Las asignaciones admin se aprueban automáticamente
                    ]);
                    
                    $reservasCreadas++;
                }
            }
        }
        
        // Crear notificación para el profesor
        if ($reservasCreadas > 0) {
            // Crear una notificación resumen
            \App\Models\Notificacion::create([
                'user_id' => $request->user_id,
                'tipo' => 'asignacion_horarios',
                'titulo' => 'Horarios asignados',
                'mensaje' => "Se han asignado {$reservasCreadas} horarios para el aula {$aula->nombre} desde {$fechaInicio->format('d/m/Y')} hasta {$fechaFin->format('d/m/Y')}."
            ]);
        }
        
        $mensaje = "Asignación completada exitosamente. {$reservasCreadas} reservas creadas para el profesor {$profesor->name}.";
        
        if (count($conflictos) > 0) {
            $mensaje .= " Se encontraron " . count($conflictos) . " conflictos en las fechas: " . implode(', ', array_slice($conflictos, 0, 5));
            if (count($conflictos) > 5) {
                $mensaje .= " y " . (count($conflictos) - 5) . " más.";
            }
        }
        
        return redirect()->route('admin.asignaciones.index')
            ->with('success', $mensaje);
    }

    /**
     * Mostrar asignaciones existentes
     */
    public function show()
    {
        $asignaciones = Reserva::with(['user', 'aula'])
            ->where('observaciones', 'like', '%Asignación administrativa%')
            ->where('fecha', '>=', now()->format('Y-m-d'))
            ->orderBy('fecha', 'asc')
            ->paginate(20);
            
        return view('admin.asignaciones.show', compact('asignaciones'));
    }

    /**
     * Eliminar asignación masiva
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'aula_id' => 'required|exists:aulas,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $eliminadas = Reserva::where('user_id', $request->user_id)
            ->where('aula_id', $request->aula_id)
            ->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin])
            ->where('observaciones', 'like', '%Asignación administrativa%')
            ->where('fecha', '>=', now()->format('Y-m-d'))
            ->delete();

        return redirect()->route('admin.asignaciones.show')
            ->with('success', "Se eliminaron {$eliminadas} asignaciones.");
    }
}
