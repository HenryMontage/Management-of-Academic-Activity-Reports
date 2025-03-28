<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class LichBaoCaoRequest extends FormRequest
{
    /**
     * Xác thực quyền gửi request
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Rules validation cho store và update
     */
    public function rules(): array
    {
        $maLich = $this->route('lichbaocao'); // Route binding
        
        return [
            'chuDe' => 'required|string|max:255',
            'ngayBaoCao' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $minNgayBaoCao = now()->addDays(7)->format('Y-m-d');
                    if ($value < $minNgayBaoCao) {
                        $fail("Ngày báo cáo chỉ được chọn sau hôm nay ít nhất 7 ngày (từ $minNgayBaoCao trở đi).");
                    }
                }
            ],
            'gioBaoCao' => 'required',
            'boMon_id' => 'required|exists:bo_mons,maBoMon',
            'giangVienPhuTrach' => 'required|array',
            'giangVienPhuTrach.*' => 'exists:giang_viens,maGiangVien',
            'hanNgayNop' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $today = now()->format('Y-m-d');
                    $ngayBaoCao = new Carbon($this->ngayBaoCao);
                    $maxHanNgayNop = $ngayBaoCao->subDays(3)->format('Y-m-d');
                    if ($value < $today || $value > $maxHanNgayNop) {
                        $fail("Hạn ngày nộp phải từ $today đến $maxHanNgayNop.");
                    }
                }
            ],
            'hanGioNop' => 'required',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi
     */
    public function messages(): array
    {
        return [
            'chuDe.required' => 'Chủ đề không được để trống.',
            'chuDe.string' => 'Chủ đề phải là chuỗi ký tự.',
            'chuDe.max' => 'Chủ đề không được vượt quá 255 ký tự.',

            'ngayBaoCao.required' => 'Ngày báo cáo không được để trống.',
            'ngayBaoCao.date' => 'Ngày báo cáo không hợp lệ.',

            'gioBaoCao.required' => 'Giờ báo cáo không được để trống.',

            'boMon_id.required' => 'Bộ môn không được để trống.',
            'boMon_id.exists' => 'Bộ môn không hợp lệ.',

            'giangVienPhuTrach.required' => 'Vui lòng chọn ít nhất một giảng viên.',
            'giangVienPhuTrach.array' => 'Dữ liệu giảng viên không hợp lệ.',
            'giangVienPhuTrach.*.exists' => 'Giảng viên được chọn không hợp lệ.',

            'hanNgayNop.required' => 'Hạn ngày nộp không được để trống.',
            'hanNgayNop.date' => 'Hạn ngày nộp không hợp lệ.',

            'hanGioNop.required' => 'Hạn giờ nộp không được để trống.',
        ];
    }
}
