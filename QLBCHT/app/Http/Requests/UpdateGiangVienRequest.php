<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\GiangVien;


class UpdateGiangVienRequest extends FormRequest
{
    /**
     * Xác thực người dùng có quyền gửi request này không.
     */
    public function authorize(): bool
    {
        return true; // Đổi thành logic phân quyền nếu cần
    }

    /**
     * Định nghĩa các quy tắc validation.
     */
    public function rules(): array
{
    $maGiangVien = $this->route('maGiangVien');
    $giangVien = GiangVien::findOrFail($maGiangVien);

    $rules = [
        'ho' => 'required|string|max:255',
        'ten' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            $this->input('email') !== $giangVien->email
                ? Rule::unique('giang_viens', 'email')->ignore($maGiangVien, 'maGiangVien')
                : '',
        ],
        'sdt' => [
            'required',
            'digits_between:10,11',
            $this->input('sdt') !== $giangVien->sdt
                ? Rule::unique('giang_viens', 'sdt')->ignore($maGiangVien, 'maGiangVien')
                : '',
        ],
        'matKhau' => 'nullable|string|min:8',
        'chucVu' => 'nullable|exists:chuc_vus,maChucVu',
        'boMon_id' => 'nullable|exists:bo_mons,maBoMon',
        'anhDaiDien' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',

    ];

    $chucVu = $this->input('chucVu');
    $boMonId = $this->input('boMon_id');
      // Nếu chọn chức vụ là TBM
    if ($chucVu === 'TBM') {
        $rules['boMon_id'] = [
            'required',
            'exists:bo_mons,maBoMon',
            function ($attribute, $value, $fail) use ($maGiangVien) {
                $boMon = \App\Models\BoMon::where('maBoMon', $value)->first();
                if ($boMon && $boMon->truongBoMon !== null && $boMon->truongBoMon !== $maGiangVien) {
                    $fail('Bộ môn này đã có trưởng bộ môn.');
                }
            }
        ];
    }

    // Nếu chọn chức vụ là Trưởng Khoa
    if ($chucVu === 'TK') {
        $rules['boMon_id'] = [
            'required',
            'exists:bo_mons,maBoMon',
            function ($attribute, $value, $fail) use ($maGiangVien) {
                $boMon = \App\Models\BoMon::where('maBoMon', $value)->first();
                if (!$boMon) {
                    return; // để rule exists xử lý
                }

                $maKhoa = $boMon->maKhoa;
                $khoa = \App\Models\Khoa::where('maKhoa', $maKhoa)->first();

                if ($khoa && $khoa->truongKhoa !== null && $khoa->truongKhoa !== $maGiangVien) {
                    $fail('Khoa "' . $khoa->tenKhoa . '" đã có trưởng khoa.');
                }
            }
        ];
    }
    return $rules;
}
    
    


    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages(): array
    {
        return [
            'ho.required' => 'Vui lòng nhập họ.',
            'ten.required' => 'Vui lòng nhập tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'sdt.required' => 'Vui lòng nhập số điện thoại.',
            'sdt.digits_between' => 'Số điện thoại phải có từ 10-11 chữ số.',
            'sdt.unique' => 'Số điện thoại đã tồn tại.',
            'matKhau.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'matKhau.confirmed' => 'Mật khẩu nhập lại không khớp.',
            'chucVu.exists' => 'Chức vụ không hợp lệ.',
            'boMon_id.exists' => 'Bộ môn không hợp lệ.',
        ];
    }
}
