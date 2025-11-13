<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure session is started
        if (!$request->hasSession()) {
            $request->setLaravelSession(
                app('session.store')
            );
        }
        
        // Force session save on response
        $response = $next($request);
        
        // Save session data
        if ($request->hasSession()) {
            $request->session()->save();
        }
        
        return $response;
    }
}
