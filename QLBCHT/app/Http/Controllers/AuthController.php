<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Models\GiangVien;
use App\Models\NhanVienPDBCL;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            Session::put('last_activity', now()); // Cập nhật thời gian hoạt động
            
            $user = Auth::user();
            if ($user instanceof Admin) {
                return redirect()->route('admin.dashboard');
            }
            if ($user instanceof GiangVien || $user instanceof NhanVienPDBCL) {
                return redirect()->route('user.dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}


