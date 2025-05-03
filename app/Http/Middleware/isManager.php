<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isManager
{
    public function handle(Request $request, Closure $next): Response
    {
            if (!Auth::check() || Auth::user()->role !== 'manager') {
                return redirect()->route('unauthorized');
            ;
        }
        return $next($request);
    }
}
