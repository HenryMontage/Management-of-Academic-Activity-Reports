<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    public function show()
    {
        $guard = session('current_guard');
        $user = Auth::guard($guard)->user();

        return view('profile.show', compact('user', 'guard'));
    }

    public function update(Request $request)
{
    $guard = session('current_guard');
    $user = Auth::guard($guard)->user();

    $commonRules = [
        'ho' => 'required|string|max:50',
        'ten' => 'required|string|max:50',
        'email' => 'required|email',
        'sdt' => 'required|string',
        'matKhau' => 'nullable|string|min:8|confirmed',
        'anhDaiDien' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ];

    if ($guard === 'giang_viens') {
        $request->validate(array_merge($commonRules, [
            'email' => 'unique:giang_viens,email,' . $user->maGiangVien . ',maGiangVien',
            'sdt' => 'unique:giang_viens,sdt,' . $user->maGiangVien . ',maGiangVien',
        ]));
    } elseif ($guard === 'nhan_vien_p_d_b_c_ls') {
        $request->validate(array_merge($commonRules, [
            'email' => 'unique:nhan_vien_p_d_b_c_ls,email,' . $user->maNV . ',maNV',
            'sdt' => 'unique:nhan_vien_p_d_b_c_ls,sdt,' . $user->maNV . ',maNV',
        ]));
    }

    $data = $request->only(['ho', 'ten', 'sdt']);

    if ($request->filled('matKhau')) {
        $data['matKhau'] = bcrypt($request->matKhau);
    }

    if ($request->hasFile('anhDaiDien')) {
        // Xóa ảnh cũ nếu không phải ảnh mặc định
        if ($user->anhDaiDien && $user->anhDaiDien !== 'anhDaiDiens/anhmacdinh.jpg') {
            Storage::disk('public')->delete($user->anhDaiDien);
        }

        $path = $request->file('anhDaiDien')->store('anhDaiDiens', 'public');
        $data['anhDaiDien'] = $path;
    }


    $user->fill($data)->save();

    return redirect()->route('profile.show')->with('success', 'Cập nhật thành công!');
}


}
