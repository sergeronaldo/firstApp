<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIdInSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si l'id de l'utilisateur est présent en session
        if ($request->session()->has('user_id')) {
            return $next($request);
        }

        // Redirige vers la page de connexion si l'id de l'utilisateur n'est pas en session
        $param = $request->route()->parameter('lang');
        return redirect()->route('admin.login',['lang'=>$param]);
    }
}
