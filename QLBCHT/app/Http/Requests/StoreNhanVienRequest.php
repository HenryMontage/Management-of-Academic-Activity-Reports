<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNhanVienRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'maNV' => $this->isMethod('post') 
            ? 'required|string|max:20|unique:nhan_vien_p_d_b_c_ls,maNV' 
            : 'sometimes|string|max:20',
            'ho' => 'required|string',
            'ten' => 'required|string',
            'sdt' => 'required|string|unique:nhan_vien_p_d_b_c_ls,sdt',
            'email' => 'required|email|unique:nhan_vien_p_d_b_c_ls,email',
            'matKhau' => 'required|string|min:6',
            'anhDaiDien' => 'nullable|image|max:2048',
            'quyen_id' => 'required|exists:quyens,maQuyen', 
        ];
    }
}
