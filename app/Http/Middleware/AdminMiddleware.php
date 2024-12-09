<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class AdminMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   * @param Closure(): void $next
   */
  public function handle(Request $request, Closure $next)
  {
    // Check if the user is authenticated and an admin
    if (Auth::check() && Auth::user()->is_admin) {
      return $next($request);
    }

    // Redirect to home page if not an admin
    return redirect()->route('home');
  }
}
