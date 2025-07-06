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
        $reservas = Reserva::with(['aula', 'user'])
            ->where('user_id', auth()->id())
            ->orderBy('fecha', 'desc')
            ->take(5)
            ->get();
            
        return view('home', compact('aulas', 'reservas'));
    }
}
