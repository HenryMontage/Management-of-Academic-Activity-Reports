<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KhoaRequest extends FormRequest
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
    $khoa = $this->route('khoa'); // Route binding
    $maKhoa = $khoa instanceof \App\Models\Khoa ? $khoa->maKhoa : null;

    return [
        'maKhoa' => 'required|string|max:20|unique:khoas,maKhoa',
        'tenKhoa' => 'required|string|max:255|unique:khoas,tenKhoa,' . ($maKhoa ?? 'NULL') . ',maKhoa',
        'truongKhoa' => 'nullable|exists:giang_viens,maGiangVien',
    ];
}

    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages(): array
    {
        return [
           'maKhoa.required' => 'Mã khoa không được để trống.',
            'maKhoa.string' => 'Mã khoa phải là chuỗi ký tự.',
            'maKhoa.max' => 'Mã khoa không được vượt quá 20 ký tự.',
            'maKhoa.unique' => 'Mã khoa này đã tồn tại, vui lòng nhập mã khác.',

            'tenKhoa.required' => 'Tên khoa không được để trống.',
            'tenKhoa.string' => 'Tên khoa phải là chuỗi ký tự.',
            'tenKhoa.max' => 'Tên khoa không được vượt quá 255 ký tự.',
            'tenKhoa.unique' => 'Tên khoa này đã tồn tại, vui lòng nhập tên khác.',

            'truongKhoa.exists' => 'Trưởng khoa phải là một giảng viên hợp lệ.',

        ];
    }
}
