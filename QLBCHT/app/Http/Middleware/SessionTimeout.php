<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class SessionTimeout
{
    public function handle(Request $request, Closure $next): Response
    {
        $guards = ['admins', 'giang_viens', 'nhan_vien_p_d_b_c_ls'];
        $isAuthenticated = false;
        $currentGuard = null;

        // Kiểm tra guard nào đang đăng nhập
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $isAuthenticated = true;
                $currentGuard = $guard;
                break;
            }
        }

        if ($isAuthenticated) {
            $lastActivity = Session::get('last_activity_' . $currentGuard);

            if ($lastActivity) {
                if (now()->diffInMinutes(Carbon::parse($lastActivity)) > 30) {
                    Auth::guard($currentGuard)->logout();
                    Session::flush();
                    return redirect()->route('login')->withErrors(['timeout' => 'Phiên làm việc đã hết hạn. Vui lòng đăng nhập lại.']);
                }
            }

            // Cập nhật lại thời gian hoạt động
            Session::put('last_activity_' . $currentGuard, now());
        }

        return $next($request);
    }
}
