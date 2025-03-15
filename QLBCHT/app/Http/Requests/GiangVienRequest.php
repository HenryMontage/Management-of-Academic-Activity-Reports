<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class GiangVienRequest extends FormRequest
{
    /**
     * Xác thực người dùng có quyền gửi request này hay không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Định nghĩa các rules validation.
     */
    public function rules(): array
    {
        $maGiangVien = $this->route('giangvien'); // Lấy từ route parameter
        return [
            'maGiangVien' => $this->isMethod('post') 
                ? 'required|string|max:20|unique:giang_viens,maGiangVien' 
                : 'sometimes|string|max:20',
            'ho' => 'required|string|max:255',
            'ten' => 'required|string|max:255',
            'email' => 'required|email|unique:giang_viens,email,' . ($maGiangVien ?? 'NULL') . ',maGiangVien',
            'sdt' => 'required|digits_between:10,11|unique:giang_viens,sdt,' . ($maGiangVien ?? 'NULL') . ',maGiangVien',
            'matKhau' => $this->isMethod('post') ? 'required|string|min:8|confirmed' : 'nullable|string|min:8|confirmed',
            'chucVu' => 'nullable|exists:chuc_vus,maChucVu',
            'boMon_id' => 'nullable|exists:bo_mons,maBoMon',
            'anhDaiDien' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ];

            // Kiểm tra nếu chọn chức vụ là Trưởng Khoa
    if ($this->chucVu == 'TRUONG_KHOA') {
        $rules['maKhoa'] = [
            'required',
            'exists:khoas,maKhoa',
            function ($attribute, $value, $fail) {
                if (\App\Models\Khoa::where('truongKhoa', '!=', null)->where('maKhoa', $value)->exists()) {
                    $fail('Khoa này đã có trưởng khoa.');
                }
            }
        ];
    }

    // Kiểm tra nếu chọn chức vụ là Trưởng Bộ Môn
    if ($this->chucVu == 'TRUONG_BO_MON') {
        $rules['boMon_id'] = [
            'required',
            'exists:bo_mons,maBoMon',
            function ($attribute, $value, $fail) {
                if (\App\Models\BoMon::where('truongBoMon', '!=', null)->where('maBoMon', $value)->exists()) {
                    $fail('Bộ môn này đã có trưởng bộ môn.');
                }
            }
        ];
    }

        
    }
    

    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages(): array
    {
        return [
            'maGiangVien.required' => 'Mã giảng viên không được để trống.',
            'maGiangVien.string' => 'Mã giảng viên phải là chuỗi ký tự.',
            'maGiangVien.max' => 'Mã giảng viên không được quá 20 ký tự.',
            'maGiangVien.unique' => 'Mã giảng viên đã tồn tại.',
            'ho.required' => 'Họ không được để trống.',
            'ten.required' => 'Tên không được để trống.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email này đã tồn tại.',
            'sdt.required' => 'Số điện thoại không được để trống.',
            'sdt.digits_between' => 'Số điện thoại phải có 10-11 chữ số.',
            'sdt.unique' => 'Số điện thoại này đã tồn tại.',
            'matKhau.required' => 'Mật khẩu không được để trống.',
            'matKhau.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'matKhau.confirmed' => 'Mật khẩu nhập lại không khớp.',
            'chucVu.exists' => 'Chức vụ không hợp lệ.',
            'boMon_id.exists' => 'Bộ môn không hợp lệ.',
        ];
    }
}
