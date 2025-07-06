<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Reserva;
use App\Models\Aula;
use App\Http\Controllers\NotificacionController;

class ReservaController extends Controller
{
    public function __construct()
    {
        // En Laravel 12, el middleware se maneja de forma diferente
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservas = Reserva::with(['aula', 'user'])
            ->where('user_id', auth()->id())
            ->orderBy('fecha', 'desc')
            ->paginate(10);
        
        return view('reservas.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Verificar que el usuario sea profesor aprobado o administrador
        $user = auth()->user();
        if (!$user->isAdmin() && (!$user->isProfesor() || $user->estado !== 'aprobado')) {
            abort(403, 'No tienes permisos para crear reservas. Debes ser un profesor aprobado o administrador.');
        }
        
        $aulas = Aula::where('activo', true)->get();
        
        // Datos pre-seleccionados desde el calendario
        $aulaSeleccionada = $request->get('aula_id');
        $fechaSeleccionada = $request->get('fecha');
        $horaInicioSeleccionada = $request->get('hora_inicio');
        $horaFinSeleccionada = $request->get('hora_fin');
        
        return view('reservas.create', compact(
            'aulas', 
            'aulaSeleccionada', 
            'fechaSeleccionada', 
            'horaInicioSeleccionada',
            'horaFinSeleccionada'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar que el usuario sea profesor aprobado o administrador
        $user = auth()->user();
        if (!$user->isAdmin() && (!$user->isProfesor() || $user->estado !== 'aprobado')) {
            abort(403, 'No tienes permisos para crear reservas. Debes ser un profesor aprobado o administrador.');
        }
        
        $request->validate([
            'aula_id' => 'required|exists:aulas,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'motivo' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        // Verificar disponibilidad
        $conflicto = Reserva::where('aula_id', $request->aula_id)
            ->where('fecha', $request->fecha)
            ->where('estado', '!=', 'cancelada')
            ->where('estado', '!=', 'rechazada')
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
            return back()->withErrors(['error' => 'El aula ya está reservada en ese horario.']);
        }

        $reserva = Reserva::create([
            'user_id' => auth()->id(),
            'aula_id' => $request->aula_id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'motivo' => $request->motivo,
            'observaciones' => $request->observaciones,
        ]);

        // Crear notificación para administradores (solo si no es admin quien crea la reserva)
        if (!$user->isAdmin()) {
            NotificacionController::crearNotificacionAdmin($reserva, 'nueva_reserva');
        }

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        Gate::authorize('view', $reserva);
        return view('reservas.show_ultra_modern', compact('reserva'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        Gate::authorize('update', $reserva);
        $aulas = Aula::where('activo', true)->get();
        return view('reservas.edit', compact('reserva', 'aulas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        Gate::authorize('update', $reserva);
        
        $request->validate([
            'aula_id' => 'required|exists:aulas,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'motivo' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        $reserva->update($request->all());

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        Gate::authorize('delete', $reserva);
        $reserva->delete();

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva eliminada exitosamente.');
    }
    
    /**
     * Aprobar una reserva (solo administradores)
     */
    public function aprobar(Reserva $reserva)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $reserva->update(['estado' => 'aprobada']);
        
        // Crear notificación para el profesor
        NotificacionController::crearNotificacionProfesor($reserva, 'reserva_aprobada');
        
        return redirect()->back()
            ->with('success', 'Reserva aprobada exitosamente.');
    }
    
    /**
     * Rechazar una reserva (solo administradores)
     */
    public function rechazar(Request $request, Reserva $reserva)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $request->validate([
            'razon_rechazo' => 'required|string|max:500'
        ]);
        
        $reserva->update([
            'estado' => 'rechazada',
            'razon_rechazo' => $request->razon_rechazo
        ]);
        
        // Crear notificación para el profesor
        NotificacionController::crearNotificacionProfesor($reserva, 'reserva_rechazada');
        
        return redirect()->back()
            ->with('success', 'Reserva rechazada exitosamente.');
    }

    /**
     * Cancelar una reserva por parte del profesor
     */
    public function cancelar(Reserva $reserva)
    {
        // Verificar que el usuario sea el propietario de la reserva
        if (auth()->id() !== $reserva->user_id) {
            abort(403, 'No tienes permisos para cancelar esta reserva.');
        }
        
        // Solo se pueden cancelar reservas pendientes o aprobadas
        if (!in_array($reserva->estado, ['pendiente', 'aprobada'])) {
            return redirect()->back()
                ->with('error', 'No puedes cancelar una reserva que ya está ' . $reserva->estado . '.');
        }
        
        // Verificar que la reserva no sea en el pasado (con al menos 2 horas de anticipación)
        $fechaReserva = \Carbon\Carbon::parse($reserva->fecha . ' ' . $reserva->hora_inicio);
        $limiteCancel = \Carbon\Carbon::now()->addHours(2);
        
        if ($fechaReserva->isPast() || $fechaReserva->lte($limiteCancel)) {
            return redirect()->back()
                ->with('error', 'No puedes cancelar una reserva con menos de 2 horas de anticipación.');
        }
        
        $estadoAnterior = $reserva->estado;
        $reserva->update([
            'estado' => 'cancelada',
            'razon_rechazo' => 'Cancelada por el profesor el ' . now()->format('d/m/Y H:i')
        ]);
        
        // Crear notificación para el administrador solo si la reserva estaba aprobada
        if ($estadoAnterior === 'aprobada') {
            NotificacionController::crearNotificacionAdmin($reserva, 'reserva_cancelada');
        }
        
        $mensaje = "Reserva cancelada exitosamente. Aula {$reserva->aula->nombre} liberada para el {$reserva->fecha} de {$reserva->hora_inicio} a {$reserva->hora_fin}.";
        
        return redirect()->back()
            ->with('success', $mensaje);
    }
}
