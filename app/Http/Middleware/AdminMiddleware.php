<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Verificar si el usuario está autenticado y si es un administrador
        if (auth()->check() && auth()->user()->hasRole($role)) {
            return $next($request);
        }

        // Redirigir si el usuario no está autenticado o no es administrador
        return redirect('/')->with('error', 'Acceso denegado. Se requiere rol de administrador.');
    }
}
