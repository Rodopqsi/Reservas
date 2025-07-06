<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profesores = User::where('role', 'profesor')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.profesores.index', compact('profesores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profesores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'codigo_profesor' => 'required|string|max:20|unique:users',
        ]);

        $profesor = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'codigo_profesor' => $validated['codigo_profesor'],
            'role' => 'profesor',
            'estado' => 'aprobado', // Los creados por admin se aprueban automáticamente
        ]);

        return redirect()->route('admin.profesores.index')
            ->with('success', 'Profesor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $profesor)
    {
        if ($profesor->role !== 'profesor') {
            abort(404);
        }

        $reservas = $profesor->reservas()
            ->with('aula')
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('admin.profesores.show', compact('profesor', 'reservas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $profesor)
    {
        if ($profesor->role !== 'profesor') {
            abort(404);
        }

        return view('admin.profesores.edit', compact('profesor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $profesor)
    {
        if ($profesor->role !== 'profesor') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $profesor->id,
            'codigo_profesor' => 'required|string|max:20|unique:users,codigo_profesor,' . $profesor->id,
            'estado' => 'required|in:pendiente,aprobado,rechazado',
        ]);

        $estadoAnterior = $profesor->estado;
        $profesor->update($validated);

        // Crear notificación si el estado cambió
        if ($estadoAnterior !== $validated['estado']) {
            $this->crearNotificacionCambioEstado($profesor, $validated['estado']);
        }

        return redirect()->route('admin.profesores.index')
            ->with('success', 'Profesor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $profesor)
    {
        if ($profesor->role !== 'profesor') {
            abort(404);
        }

        // Verificar si tiene reservas activas
        $reservasActivas = $profesor->reservas()
            ->whereIn('estado', ['pendiente', 'aprobada'])
            ->where('fecha', '>=', now()->toDateString())
            ->count();

        if ($reservasActivas > 0) {
            return redirect()->route('admin.profesores.index')
                ->with('error', 'No se puede eliminar el profesor porque tiene reservas activas.');
        }

        $profesor->delete();

        return redirect()->route('admin.profesores.index')
            ->with('success', 'Profesor eliminado exitosamente.');
    }

    /**
     * Aprobar profesor
     */
    public function aprobar(User $profesor)
    {
        if ($profesor->role !== 'profesor') {
            abort(404);
        }

        $profesor->update(['estado' => 'aprobado']);
        
        $this->crearNotificacionCambioEstado($profesor, 'aprobado');

        return redirect()->route('admin.profesores.index')
            ->with('success', 'Profesor aprobado exitosamente.');
    }

    /**
     * Rechazar profesor
     */
    public function rechazar(User $profesor)
    {
        if ($profesor->role !== 'profesor') {
            abort(404);
        }

        $profesor->update(['estado' => 'rechazado']);
        
        $this->crearNotificacionCambioEstado($profesor, 'rechazado');

        return redirect()->route('admin.profesores.index')
            ->with('success', 'Profesor rechazado.');
    }

    /**
     * Obtener profesores pendientes
     */
    public function pendientes()
    {
        $profesores = User::where('role', 'profesor')
            ->where('estado', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.profesores.pendientes', compact('profesores'));
    }

    /**
     * Crear notificación de cambio de estado
     */
    private function crearNotificacionCambioEstado(User $profesor, string $nuevoEstado)
    {
        $mensajes = [
            'aprobado' => 'Tu cuenta de profesor ha sido aprobada. Ya puedes realizar reservas.',
            'rechazado' => 'Tu cuenta de profesor ha sido rechazada. Contacta al administrador para más información.',
            'pendiente' => 'Tu cuenta de profesor está pendiente de aprobación.',
        ];

        Notificacion::create([
            'user_id' => $profesor->id,
            'tipo' => 'estado_cuenta',
            'titulo' => 'Cambio de estado de cuenta',
            'mensaje' => $mensajes[$nuevoEstado],
            'leida' => false,
        ]);
    }
}
