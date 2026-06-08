<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['bericht' => 'Niet geautoriseerd.'], 401);
        }

        $medewerker = DB::table('medewerkers')
            ->where('token', $token)
            ->first();

        if (!$medewerker) {
            return response()->json(['bericht' => 'Ongeldig token.'], 401);
        }
        
        return $next($request);
    }
}
