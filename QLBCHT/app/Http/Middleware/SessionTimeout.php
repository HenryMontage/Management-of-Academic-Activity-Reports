<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('last_activity') && now()->diffInMinutes(Session::get('last_activity')) > 30) {
            Auth::logout();
            Session::invalidate();
            return redirect()->route('login')->withErrors(['timeout' => 'Phiên đăng nhập đã hết hạn.']);
        }

        Session::put('last_activity', now());

        return $next($request);
    }
}
