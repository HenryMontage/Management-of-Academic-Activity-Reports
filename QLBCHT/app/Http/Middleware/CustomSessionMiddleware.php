<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserSession;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\GiangVien;
use App\Models\NhanVienPDBCL;
use Illuminate\Support\Facades\Cookie;
class CustomSessionMiddleware
{
    public function handle(Request $request, Closure $next)
{
    $sessionId = Session::get('session_id') ?? $request->cookie('persistent_session_id');

    if ($sessionId) {
        $session = UserSession::where('session_id', $sessionId)->first();

        if ($session) {
            if (Carbon::parse($session->last_activity)->diffInMinutes(now()) > 30) {
                $session->delete();
                Session::flush();
                Cookie::queue(Cookie::forget('persistent_session_id'));
                return redirect()->route('login')->withErrors(['timeout' => 'Phiên làm việc đã hết hạn.']);
            }

            $guard = $session->user_type;
            $ma = $session->user_ma;

            if (!Auth::guard($guard)->check()) {
                $user = null;
                if ($guard === 'admins') {
                    $user = Admin::where('maAdmin', $ma)->first();
                } elseif ($guard === 'giang_viens') {
                    $user = GiangVien::where('maGiangVien', $ma)->first();
                } elseif ($guard === 'nhan_vien_p_d_b_c_ls') {
                    $user = NhanVienPDBCL::where('maNV', $ma)->first();
                }

                if ($user) {
                    Auth::guard($guard)->login($user);
                    Session::put('session_id', $sessionId); // restore vào session
                    Session::put('current_guard', $guard);
                }
            }

            $session->update(['last_activity' => now()]);
        } else {
            Session::flush();
            Cookie::queue(Cookie::forget('persistent_session_id'));
            return redirect()->route('login');
        }
    }

    return $next($request);
}
}
