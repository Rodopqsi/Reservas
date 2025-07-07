<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Verificar si el usuario está aprobado
            if ($user->estado !== 'aprobado') {
                Auth::logout();
                
                $mensaje = match($user->estado) {
                    'pendiente' => 'Tu cuenta está pendiente de aprobación por el administrador.',
                    'rechazado' => 'Tu cuenta ha sido rechazada. Contacta al administrador.',
                    default => 'Tu cuenta no está activa. Contacta al administrador.'
                };
                
                return redirect()->route('login')->with('error', $mensaje);
            }
        }
        
        return $next($request);
    }
}
