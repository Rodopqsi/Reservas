<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Aula;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        // En Laravel 12, el middleware se maneja de forma diferente
    }

    public function index()
    {
        $totalReservas = Reserva::count();
        $reservasPendientes = Reserva::where('estado', 'pendiente')->count();
        $totalAulas = Aula::count();
        $totalProfesores = User::where('role', 'profesor')->count();

        $reservasRecientes = Reserva::with(['user', 'aula'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalReservas',
            'reservasPendientes',
            'totalAulas',
            'totalProfesores',
            'reservasRecientes'
        ));
    }

    public function reservas()
    {
        $reservas = Reserva::with(['user', 'aula'])
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('admin.reservas.index', compact('reservas'));
    }

    public function aprobarReserva(Reserva $reserva)
    {
        $reserva->update(['estado' => 'aprobada']);
        return back()->with('success', 'Reserva aprobada exitosamente.');
    }

    public function rechazarReserva(Request $request, Reserva $reserva)
    {
        $request->validate([
            'razon_rechazo' => 'required|string|max:255',
        ]);

        $reserva->update([
            'estado' => 'rechazada',
            'razon_rechazo' => $request->razon_rechazo,
        ]);

        return back()->with('success', 'Reserva rechazada exitosamente.');
    }
}
