<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    if (Auth::check() && Auth::user()->status === 0) {
      // Auth::guard()->logout();
      // auth()->logout();
      auth('web')->logout();

      $request->session()->invalidate();

      $request->session()->regenerateToken();

      return redirect()->route('login')->with('suspend_error', 'Votre compte est suspendu, veuillez contacter l\'administrateur.');
    }

    return $next($request);
  }
}
