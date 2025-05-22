<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Models\GiangVien;
use App\Models\NhanVienPDBCL;
use App\Models\sessions;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Str;
use App\Models\UserSession;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $currentGuard = Session::get('current_guard');

        if ($currentGuard && Auth::guard($currentGuard)->check()) {
            return redirect()->route($currentGuard === 'admins' ? 'admin.dashboard' : 'user.dashboard');
        }
    
        return view('auth.login');
    }

public function login(Request $request)
{
    $request->validate([
        'ma' => 'required',
        'password' => 'required',
    ]);

    $ma = $request->input('ma');
    $password = $request->input('password');

    // ADMIN
    if (Auth::guard('admins')->attempt(['maAdmin' => $ma, 'password' => $password])) {
        return $this->storeSessionAndRedirect('admins', $ma, 'admin.dashboard');
    }

    // GIẢNG VIÊN
    if (Auth::guard('giang_viens')->attempt(['maGiangVien' => $ma, 'password' => $password])) {
        return $this->storeSessionAndRedirect('giang_viens', $ma, 'user.dashboard');
    }

    // NHÂN VIÊN PĐBCL
    if (Auth::guard('nhan_vien_p_d_b_c_ls')->attempt(['maNV' => $ma, 'password' => $password])) {
        return $this->storeSessionAndRedirect('nhan_vien_p_d_b_c_ls', $ma, 'user.dashboard');
    }

    return back()->withErrors(['ma' => 'Mã số hoặc mật khẩu không chính xác.']);
}

protected function storeSessionAndRedirect($guard, $ma, $route)
{
    // Xoá session cũ nếu có
    UserSession::where('user_type', $guard)->where('user_ma', $ma)->delete();

    $sessionId = Str::uuid()->toString();

    // Lưu cả vào session và cookie
    Session::put('session_id', $sessionId);
    Session::put('current_guard', $guard);

    // Lưu thêm cookie (giữ trong 1 ngày = 1440 phút)
    Cookie::queue('persistent_session_id', $sessionId, 1440);

    UserSession::create([
        'user_type' => $guard,
        'user_ma' => $ma,
        'session_id' => $sessionId,
        'last_activity' => now(),
    ]);

    return redirect()->route($route);
}

public function logout(Request $request)
{
    $sessionId = Session::get('session_id');

    $guards = ['admins', 'giang_viens', 'nhan_vien_p_d_b_c_ls'];
    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            Auth::guard($guard)->logout(); // ✅ logout trước
            break;
        }
    }

    // ❗️Xoá bản ghi UserSession
    if ($sessionId) {
        UserSession::where('session_id', $sessionId)->delete();
    }

    Session::flush(); // ❗️Đặt sau cùng
    return redirect()->route('login');
}

}

