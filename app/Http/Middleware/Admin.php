<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function __construct(Guard $auth)
    {
        //
    }
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->role !== User::ROLE_ADMIN) {
            return redirect('/dashboard')->with('error', "Access Denied , You are not allowed to perform this action");
        }
        return $next($request);
    }
}
