<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ho' => 'required|string|max:255',
            'ten' => 'required|string|max:255',
            'sdt' => 'required|digits:10|unique:admins,sdt,' . $this->route('admin') . ',maAdmin',
            'email' => 'required|email|unique:admins,email,' . $this->route('admin') . ',maAdmin',
            'matKhau' => 'required|min:8|confirmed',
            'quyen_id' => 'nullable|exists:quyens,maQuyen',
        ];
    }

    public function messages(): array
    {
        return [
            'ho.required' => 'Họ là bắt buộc.',
            'ho.string' => 'Họ phải là chữ.',
            'ho.max' => 'Họ không được vượt quá 255 ký tự.',

            'ten.required' => 'Tên là bắt buộc.',
            'ten.string' => 'Tên phải là chữ.',
            'ten.max' => 'Tên không được vượt quá 255 ký tự.',

            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã tồn tại.',

            'sdt.required' => 'Số điện thoại là bắt buộc.',
            'sdt.digits' => 'Số điện thoại phải có đúng 10 chữ số.',

            'matKhau.required' => 'Mật khẩu là bắt buộc.',
            'matKhau.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'matKhau.confirmed' => 'Mật khẩu nhập lại không khớp.',
        ];
    }
}
