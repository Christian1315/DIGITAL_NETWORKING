<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAgency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Is_User_An_Agency(request()->user()->id)) {
            return response()->json([
                'status' => false,
                "message" => "Seuls les Agences(partenaires) sont autorisés à effectuer cette opération"
            ], 404);
        }
        return $next($request);
    }
}
