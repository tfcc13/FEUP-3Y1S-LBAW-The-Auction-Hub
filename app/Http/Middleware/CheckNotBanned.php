<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class CheckNotBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_banned) {
            return redirect()->route('banned');
        }

        return $next($request);
    }
}
