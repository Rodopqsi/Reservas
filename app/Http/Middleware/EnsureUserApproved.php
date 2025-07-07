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
        
        // Si no hay usuario autenticado, continuar (será manejado por auth middleware)
        if (!$user) {
            return $next($request);
        }
        
        // Si es admin, siempre permitir acceso
        if ($user->isAdmin()) {
            return $next($request);
        }
        
        // Para profesores, verificar que esté aprobado
        if ($user->isProfesor()) {
            if ($user->estado === 'pendiente') {
                return redirect()->route('pending-approval');
            }
            
            if ($user->estado === 'rechazada' || $user->estado === 'rechazado') {
                return redirect()->route('account-rejected');
            }
            
            if ($user->estado !== 'aprobado') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Tu cuenta no está activa. Contacta al administrador.');
            }
        }
        
        return $next($request);
    }
}
