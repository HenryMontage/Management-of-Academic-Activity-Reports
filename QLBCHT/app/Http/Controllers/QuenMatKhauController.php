<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\GiangVien;
use App\Models\NhanVienPDBCL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class QuenMatKhauController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'ma' => 'required',
        ]);

        $ma = $request->input('ma');
        $user = null;
        $email = null;
        $guard = null;

        // Tìm user theo từng bảng
        if ($user = Admin::where('maAdmin', $ma)->first()) {
            $email = $user->email;
            $guard = 'admins';
            $maSo = $user->maAdmin; 
        } elseif ($user = GiangVien::where('maGiangVien', $ma)->first()) {
            $email = $user->email;
            $guard = 'giang_viens';
            $maSo = $user->maGiangVien;
        } elseif ($user = NhanVienPDBCL::where('maNV', $ma)->first()) {
            $email = $user->email;
            $guard = 'nhan_vien_p_d_b_c_ls';
            $maSo = $user->maNV;
        }

        if (!$user || !$email) {
            return back()->withErrors(['ma' => 'Mã số không tồn tại.']);
        }

        // Sinh mã xác thực 4 số
        $code = rand(1000, 9999);

        // Lưu vào session
        Session::put('reset_code', $code);
        Session::put('reset_code_expired', now()->addMinutes(1)); // hết hạn sau 1 phút
        Session::put('reset_user', [
            'guard' => $guard,
            'ma' => $maSo,
        ]);

        // Gửi email
        Mail::raw("Mã xác thực đặt lại mật khẩu của bạn là: $code", function ($message) use ($email) {
            $message->to($email)->subject('Mã xác thực đặt lại mật khẩu');
        });

        return redirect()->route('password.reset')->with('status', 'Mã xác thực đã được gửi đến email của bạn.');
    }

    public function showResetForm()
    {
        $userData = Session::get('reset_user');
        $ma = $userData['ma'];
        return view('auth.reset-password',compact('ma'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric',
            'password' => 'required|min:8|confirmed',
        ]);

        $code = $request->input('code');
        $password = $request->input('password');

        if (!Session::has('reset_code') || !Session::has('reset_code_expired') || !Session::has('reset_user')) {
            return back()->withErrors(['code' => 'Mã xác thực không hợp lệ hoặc đã hết hạn.']);
        }

        if (now()->gt(Session::get('reset_code_expired'))) {
            Session::forget(['reset_code', 'reset_code_expired', 'reset_user']);
            return back()->withErrors(['code' => 'Mã xác thực đã hết hạn.']);
        }

        if ($code != Session::get('reset_code')) {
            return back()->withErrors(['code' => 'Mã xác thực không đúng.']);
        }

        $userData = Session::get('reset_user');

        switch ($userData['guard']) {
            case 'admins':
                $user = Admin::where('maAdmin', $userData['ma'])->first();
                break;
            case 'giang_viens':
                $user = GiangVien::where('maGiangVien', $userData['ma'])->first();
                break;
            case 'nhan_vien_p_d_b_c_ls':
                $user = NhanVienPDBCL::where('maNV', $userData['ma'])->first();
                break;
            default:
                $user = null;
        }

        $user->matKhau = Hash::make($password);
        $user->save();

        // if ($user) {
          
        // }

        Session::forget(['reset_code', 'reset_code_expired', 'reset_user']);

        return redirect()->route('login')->with('status', 'Đổi mật khẩu thành công. Bạn hãy đăng nhập lại.');
    }
}
