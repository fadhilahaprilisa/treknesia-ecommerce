<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('admin_id')) {
            return redirect('/login-admin')->with('error', 'Silakan login sebagai admin.');
        }

        return $next($request);
    }
}