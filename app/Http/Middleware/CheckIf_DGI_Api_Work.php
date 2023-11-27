<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIf_DGI_Api_Work
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (IS_DGI_API_WORKING()!=1) {
            return response()->json([
                'status' => false,
                "message" => "Désolé! L'api de l'e-MCF de la DGI n'est pas fonctionnelle. Ceci peut être dû à la non validité de votre JETON"
            ], 404);
        }
        return $next($request);
    }
}
