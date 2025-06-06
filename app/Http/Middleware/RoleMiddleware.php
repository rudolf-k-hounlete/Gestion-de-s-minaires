<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Si l'utilisateur n'est pas authentifié, on renvoie 403
        if (!Auth::check()) {
            abort(403);
        }

        $user = Auth::user();

        // Vérifie que $user->role figure dans la liste des rôles passés en paramètre
        if (! in_array($user->role, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
