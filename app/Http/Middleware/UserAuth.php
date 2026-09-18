<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user_id')) {
            return redirect('/login-user')->with('error', 'Silakan login terlebih dahulu untuk berbelanja.');
        }

        return $next($request);
    }
}