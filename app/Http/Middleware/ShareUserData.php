<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ShareUserData
{
    public function handle($request, Closure $next)
    {
        // Mendapatkan data pengguna
        $user = Auth::user();

        // Menyebarkan data pengguna ke semua tampilan
        View::share('user', $user);

        return $next($request);
    }
}
