<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoMonRequest extends FormRequest
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
    $bomonId = $this->route('bomon') ? $this->route('bomon')->maBoMon : null;

    return [
        'maBoMon' => 'required|string|max:20|unique:bo_mons,maBoMon,' . $bomonId . ',maBoMon',
        'tenBoMon' => 'required|string|max:255|unique:bo_mons,tenBoMon,' . $bomonId . ',maBoMon',
        'maKhoa' => 'nullable|string|exists:khoas,maKhoa',
        'truongBoMon' => 'nullable|string|exists:giang_viens,maGiangVien',
    ];
}


    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages(): array
    {
        return [
            'maBoMon.required' => 'Mã Bộ Môn không được để trống.',
            'maBoMon.string' => 'Mã Bộ Môn phải là chuỗi ký tự.',
            'maBoMon.max' => 'Mã Bộ Môn không được vượt quá 20 ký tự.',
            'maBoMon.unique' => 'Mã Bộ Môn này đã tồn tại, vui lòng nhập mã khác.',

            'tenBoMon.required' => 'Tên Bộ Môn không được để trống.',
            'tenBoMon.string' => 'Tên Bộ Môn phải là chuỗi ký tự.',
            'tenBoMon.max' => 'Tên Bộ Môn không được vượt quá 255 ký tự.',
            'tenBoMon.unique' => 'Tên Bộ Môn này đã tồn tại, vui lòng nhập tên khác.',

            'maKhoa.exists' => 'Mã Khoa không hợp lệ.',
            'truongBoMon.exists' => 'Mã giảng viên không hợp lệ.',

        ];
    }
}
