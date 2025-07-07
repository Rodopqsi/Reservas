<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AsignacionController;
use App\Http\Controllers\NotificacionController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas para reservas (solo index, show y cancelar para todos)
    Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');
    Route::get('/reservas/create', [ReservaController::class, 'create'])->name('reservas.create');
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/reservas/{reserva}', [ReservaController::class, 'show'])->name('reservas.show');
    Route::post('/reservas/{reserva}/cancelar', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');
    
    // Rutas para calendario
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');
    Route::get('/calendario/simple', [CalendarioController::class, 'simple'])->name('calendario.simple');
    Route::get('/calendario/debug', [CalendarioController::class, 'debug'])->name('calendario.debug');
    Route::get('/calendario/disponibilidad', [CalendarioController::class, 'disponibilidad'])->name('calendario.disponibilidad');
    
    // API para calendario
    Route::get('/api/calendario/datos', [CalendarioController::class, 'obtenerDatos'])->name('api.calendario.datos');
    
    // Rutas para notificaciones
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::post('/notificaciones/{notificacion}/marcar-leida', [NotificacionController::class, 'marcarComoLeida'])->name('notificaciones.marcar-leida');
    Route::post('/notificaciones/marcar-todas-leidas', [NotificacionController::class, 'marcarTodasComoLeidas'])->name('notificaciones.marcar-todas-leidas');
    
    // API para notificaciones
    Route::get('/api/notificaciones/pendientes', [NotificacionController::class, 'pendientes'])->name('api.notificaciones.pendientes');
    Route::get('/api/notificaciones/verificar-nuevas', [NotificacionController::class, 'verificarNuevas'])->name('api.notificaciones.verificar-nuevas');
});

// Rutas solo para profesores (con middleware de aprobación)
Route::middleware(['auth', 'profesor', 'approved'])->group(function () {
    Route::get('/reservas/{reserva}/edit', [ReservaController::class, 'edit'])->name('reservas.edit');
    Route::put('/reservas/{reserva}', [ReservaController::class, 'update'])->name('reservas.update');
});

// Rutas de administración
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reservas', [DashboardController::class, 'reservas'])->name('reservas.index');
    Route::post('/reservas/{reserva}/aprobar', [DashboardController::class, 'aprobarReserva'])->name('reservas.aprobar');
    Route::post('/reservas/{reserva}/rechazar', [DashboardController::class, 'rechazarReserva'])->name('reservas.rechazar');
    Route::resource('aulas', AulaController::class);
    
    // Rutas para asignaciones
    Route::get('/asignaciones', [AsignacionController::class, 'index'])->name('asignaciones.index');
    Route::post('/asignaciones', [AsignacionController::class, 'store'])->name('asignaciones.store');
    Route::get('/asignaciones/mostrar', [AsignacionController::class, 'show'])->name('asignaciones.show');
    Route::delete('/asignaciones/eliminar', [AsignacionController::class, 'destroy'])->name('asignaciones.destroy');
    
    // Rutas para gestión de profesores
    Route::resource('profesores', \App\Http\Controllers\Admin\ProfesoresController::class)->parameters(['profesores' => 'profesor']);
    Route::get('/profesores-pendientes', [\App\Http\Controllers\Admin\ProfesoresController::class, 'pendientes'])->name('profesores.pendientes');
    Route::patch('/profesores/{profesor}/aprobar', [\App\Http\Controllers\Admin\ProfesoresController::class, 'aprobar'])->name('profesores.aprobar');
    Route::patch('/profesores/{profesor}/rechazar', [\App\Http\Controllers\Admin\ProfesoresController::class, 'rechazar'])->name('profesores.rechazar');
});

// Página de bienvenida personalizada
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Página Nosotros
Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

// Rutas públicas para pruebas
Route::get('/test/calendario', function() {
    return view('welcome')->with('mensaje', 'Sistema de reservas funcionando correctamente');
});

Route::get('/test/calendario/datos', [CalendarioController::class, 'obtenerDatos'])->name('test.calendario.datos');

// Ruta temporal para pruebas de desarrollo (REMOVER EN PRODUCCIÓN)
Route::get('/test/reservas/create', function() {
    $aulas = \App\Models\Aula::where('activo', true)->get();
    return view('reservas.create', compact('aulas'))->with([
        'aulaSeleccionada' => request('aula_id'),
        'fechaSeleccionada' => request('fecha'),
        'horaInicioSeleccionada' => request('hora_inicio'),
        'horaFinSeleccionada' => request('hora_fin')
    ]);
})->name('test.reservas.create');

// Ruta directa para crear reservas sin dependencias
Route::get('/reservas-crear', function() {
    return response()->file(public_path('reservas_create_simple.html'));
})->name('reservas.crear.directo');

// Ruta de depuración para el problema del show
Route::get('/debug/reserva/{id}', function ($id) {
    $reserva = \App\Models\Reserva::with(['user', 'aula'])->findOrFail($id);
    
    return [
        'reserva' => $reserva,
        'user_can_view' => auth()->user()->can('view', $reserva),
        'routes' => [
            'reservas.show' => route('reservas.show', $reserva),
            'reservas.index' => route('reservas.index'),
            'reservas.cancelar' => route('reservas.cancelar', $reserva),
        ]
    ];
})->middleware('auth');

// API para calendario en tiempo real
Route::get('/api/calendario-data', [CalendarioController::class, 'obtenerDatosJson'])
    ->name('api.calendario.data')
    ->middleware('auth');

require __DIR__.'/auth.php';
