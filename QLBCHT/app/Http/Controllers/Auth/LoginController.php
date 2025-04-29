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

class LoginController extends Controller
{
    public function showLoginForm()
    {
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

    // Thử đăng nhập với admin
    if (Auth::guard('admins')->attempt(['maAdmin' => $ma, 'password' => $password])) {
        Session::put('last_activity_admins', now());
        Session::put('current_guard', 'admins');
        return redirect()->route('admin.dashboard');
    }

    // Thử đăng nhập với giảng viên
    if (Auth::guard('giang_viens')->attempt(['maGiangVien' => $ma, 'password' => $password])) {
        Session::put('last_activity_giang_viens', now());
        Session::put('current_guard', 'giang_viens');
        return redirect()->route('user.dashboard');
    }

    // Thử đăng nhập với nhân viên phòng đảm bảo chất lượng
    if (Auth::guard('nhan_vien_p_d_b_c_ls')->attempt(['maNV' => $ma, 'password' => $password])) {
        Session::put('last_activity_nhan_vien_p_d_b_c_ls', now());
        Session::put('current_guard', 'nhan_vien_p_d_b_c_ls');
        return redirect()->route('user.dashboard');
    }

    // Nếu không đăng nhập được
    return back()->withErrors([
        'ma' => 'Mã số hoặc mật khẩu không chính xác.',
    ]);
}

    


public function logout(Request $request)
{
    $guards = ['admins', 'giang_viens', 'nhan_vien_p_d_b_c_ls'];
    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            Auth::guard($guard)->logout();
            break;
        }
    }

    Session::flush();
    return redirect()->route('login');
}

}

