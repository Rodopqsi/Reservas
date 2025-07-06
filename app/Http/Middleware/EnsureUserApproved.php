<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Si es admin, siempre permitir acceso
        if ($user && $user->isAdmin()) {
            return $next($request);
        }
        
        // Si es profesor, verificar que esté aprobado
        if ($user && $user->isProfesor()) {
            if ($user->estado === 'pendiente') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Tu cuenta está pendiente de aprobación por el administrador.');
            }
            
            if ($user->estado === 'rechazado') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Tu cuenta ha sido rechazada. Contacta al administrador para más información.');
            }
        }
        
        return $next($request);
    }
}
