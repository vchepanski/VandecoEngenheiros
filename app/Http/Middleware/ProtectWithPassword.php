<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProtectWithPassword
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('access_granted')) {
            return redirect('/access');
        }

        return $next($request);
    }
}

