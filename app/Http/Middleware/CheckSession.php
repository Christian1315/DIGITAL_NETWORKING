<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!CheckSessionExiste(request()->user()->id)) {
            return response()->json([
                'status' => false,
                "message" => "Vous n'avez pas de session! Veuillez en initier une!"
            ], 404);
        }
        if (!CheckSessionActive(request()->user()->id)) {
            return response()->json([
                'status' => false,
                "message" => "Votre session n'est pas active! Veuillez l'activer"
            ], 404);
        }
        return $next($request);
    }
}
