<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
         if(!$user || !$user->is_admin){
            return response()->json([
                "message"=> "Error: You are not an admin"
            ], 403);
         }
        return $next($request);
    }
}
