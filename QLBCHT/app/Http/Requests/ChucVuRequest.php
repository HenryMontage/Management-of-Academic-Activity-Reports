<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChucVuRequest extends FormRequest
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
        $chucVu = $this->route('chucvu'); // Route binding
        $maChucVu = $chucVu ? $chucVu->maChucVu : null;

        return [
            'tenChucVu' => 'required|string|max:255|unique:chuc_vus,tenChucVu,' . ($maChucVu ?? 'NULL') . ',maChucVu',
            'quyen_id' => 'nullable|integer|exists:quyens,maQuyen',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages(): array
    {
        return [
           'tenChucVu.required' => 'Tên chức vụ không được để trống.',
            'tenChucVu.string' => 'Tên chức vụ phải là chuỗi ký tự.',
            'tenChucVu.max' => 'Tên chức vụ không được vượt quá 255 ký tự.',
            'tenChucVu.unique' => 'Tên chức vụ này đã tồn tại, vui lòng nhập tên khác.',

            'quyen_id.integer' => 'Quyền phải là một số nguyên.',
            'quyen_id.exists' => 'Quyền được chọn không hợp lệ.',
        ];
    }
}
