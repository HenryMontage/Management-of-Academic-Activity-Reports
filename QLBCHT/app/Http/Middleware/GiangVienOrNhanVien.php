<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class GiangVienOrNhanVien
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('giang_viens')->check() || Auth::guard('nhan_vien_p_d_b_c_ls')->check()) {
            return $next($request);
        }

        return redirect()->route('login'); // hoặc abort(403, 'Không có quyền truy cập');
    }
}
