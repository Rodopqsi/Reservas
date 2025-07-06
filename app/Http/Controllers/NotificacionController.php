<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    /**
     * Obtener notificaciones del usuario actual
     */
    public function index(Request $request)
    {
        $notificaciones = $request->user()->notificaciones()
            ->with(['reserva' => function($query) {
                $query->with('aula');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('notificaciones.index', compact('notificaciones'));
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarComoLeida($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        
        // Verificar que la notificación pertenece al usuario actual
        if ($notificacion->user_id !== auth()->id()) {
            abort(403);
        }
        
        $notificacion->update(['leida' => true]);
        
        return response()->json(['success' => true]);
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function marcarTodasComoLeidas()
    {
        auth()->user()->notificaciones()->update(['leida' => true]);
        
        return response()->json(['success' => true]);
    }

    /**
     * Crear notificación para administradores
     */
    public static function crearNotificacionAdmin($reserva, $tipo)
    {
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            $mensaje = self::generarMensaje($reserva, $tipo);
            
            Notificacion::create([
                'user_id' => $admin->id,
                'reserva_id' => $reserva->id,
                'tipo' => $tipo,
                'titulo' => $mensaje['titulo'],
                'mensaje' => $mensaje['mensaje'],
            ]);
        }
    }

    /**
     * Crear notificación para profesor
     */
    public static function crearNotificacionProfesor($reserva, $tipo)
    {
        $mensaje = self::generarMensaje($reserva, $tipo);
        
        Notificacion::create([
            'user_id' => $reserva->user_id,
            'reserva_id' => $reserva->id,
            'tipo' => $tipo,
            'titulo' => $mensaje['titulo'],
            'mensaje' => $mensaje['mensaje'],
        ]);
    }

    /**
     * Generar mensaje según el tipo de notificación
     */
    private static function generarMensaje($reserva, $tipo)
    {
        switch ($tipo) {
            case 'nueva_reserva':
                return [
                    'titulo' => 'Nueva reserva pendiente',
                    'mensaje' => "El profesor {$reserva->user->name} ha solicitado reservar el aula {$reserva->aula->nombre} para el {$reserva->fecha->format('d/m/Y')} de {$reserva->hora_inicio} a {$reserva->hora_fin}."
                ];
            
            case 'reserva_aprobada':
                return [
                    'titulo' => 'Reserva aprobada',
                    'mensaje' => "Tu reserva del aula {$reserva->aula->nombre} para el {$reserva->fecha->format('d/m/Y')} de {$reserva->hora_inicio} a {$reserva->hora_fin} ha sido aprobada."
                ];
            
            case 'reserva_rechazada':
                return [
                    'titulo' => 'Reserva rechazada',
                    'mensaje' => "Tu reserva del aula {$reserva->aula->nombre} para el {$reserva->fecha->format('d/m/Y')} de {$reserva->hora_inicio} a {$reserva->hora_fin} ha sido rechazada."
                ];
            
            case 'reserva_cancelada':
                return [
                    'titulo' => 'Reserva cancelada',
                    'mensaje' => "Tu reserva del aula {$reserva->aula->nombre} para el {$reserva->fecha->format('d/m/Y')} de {$reserva->hora_inicio} a {$reserva->hora_fin} ha sido cancelada."
                ];
            
            case 'asignacion_horarios':
                return [
                    'titulo' => 'Horarios asignados',
                    'mensaje' => "Se han asignado nuevos horarios para el aula {$reserva->aula->nombre}."
                ];
            
            default:
                return [
                    'titulo' => 'Actualización de reserva',
                    'mensaje' => "Ha habido una actualización en tu reserva del aula {$reserva->aula->nombre}."
                ];
        }
    }

    /**
     * API: Obtener notificaciones pendientes
     */
    public function pendientes()
    {
        $user = auth()->user();
        $count = $user->notificacionesNoLeidas()->count();
        
        // Obtener resumen de reservas pendientes de aprobación para administradores
        $resumen = [];
        if ($user->isAdmin()) {
            $reservasPendientes = \App\Models\Reserva::where('estado', 'pendiente')->count();
            if ($reservasPendientes > 0) {
                $resumen['reservas_pendientes'] = $reservasPendientes;
            }
        }
        
        return response()->json([
            'count' => $count,
            'resumen' => $resumen,
            'mensaje' => $count > 0 ? "Tienes {$count} notificación" . ($count > 1 ? 'es' : '') . " pendiente" . ($count > 1 ? 's' : '') : null
        ]);
    }

    /**
     * API: Obtener última verificación de notificaciones
     * Para evitar mostrar duplicados
     */
    public function verificarNuevas()
    {
        $user = auth()->user();
        $ultimaVerificacion = session('ultima_verificacion_notificaciones', now()->subMinutes(30));
        
        $nuevasNotificaciones = $user->notificaciones()
            ->where('created_at', '>', $ultimaVerificacion)
            ->where('leida', false)
            ->count();
        
        // Actualizar última verificación
        session(['ultima_verificacion_notificaciones' => now()]);
        
        return response()->json([
            'nuevas' => $nuevasNotificaciones,
            'total' => $user->notificacionesNoLeidas()->count()
        ]);
    }
}
