<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaster
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Is_User_A_Master(request()->user()->id)) {
            return response()->json([
                'status'=>true,
                "message"=>"Seuls les Masters sont autorisés à effectuer cette opération"
            ],404);
        }
        return $next($request);
    }
}
