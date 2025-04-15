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
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('admins')->attempt($credentials)) {
            Session::put('last_activity_admins', now());
            Session::put('current_guard', 'admins'); // 👈 THÊM DÒNG NÀY
            return redirect()->route('admin.dashboard');
        }
    
        if (Auth::guard('giang_viens')->attempt($credentials)) {
            Session::put('last_activity_giang_viens', now());
            Session::put('current_guard', 'giang_viens'); // 👈 THÊM DÒNG NÀY
            return redirect()->route('user.dashboard');
        }
    
        if (Auth::guard('nhan_vien_p_d_b_c_ls')->attempt($credentials)) {
            Session::put('last_activity_nhan_vien_p_d_b_c_ls', now());
            Session::put('current_guard', 'nhan_vien_p_d_b_c_ls'); // 👈 THÊM DÒNG NÀY
            return redirect()->route('user.dashboard');
        }
    
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
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

