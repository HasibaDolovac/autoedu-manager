<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProveraAdmina
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
   public function handle(Request $request, Closure $next)
{
    // Ako korisnik NIJE admin, šalji ga na početnu sa porukom
    if (auth()->user()->role !== 'admin') {
        return redirect('/')->with('error', 'Nemate dozvolu za ovu akciju!');
    }

    return $next($request);
}
}
