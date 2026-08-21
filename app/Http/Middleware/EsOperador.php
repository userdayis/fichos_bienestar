<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EsOperador
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Admin puede acceder a todo
        if ($user->esAdmin()) {
            return $next($request);
        }

        if (!$user->esOperador()) {
            abort(403, 'No tienes una actividad asignada. Contacta al administrador.');
        }

        return $next($request);
    }
}
