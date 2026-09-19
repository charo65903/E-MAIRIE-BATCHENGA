<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Bloque l'accès aux routes réservées à un ou plusieurs rôles.
     * Usage : ->middleware('role:agent') ou ->middleware('role:agent,administrateur')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if (! in_array($request->user()->role, $roles, true)) {
            abort(403, "Vous n'êtes pas autorisé à accéder à cette page.");
        }

        return $next($request);
    }
}
