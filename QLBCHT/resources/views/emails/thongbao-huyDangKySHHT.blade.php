<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo hủy đăng ký sinh hoạt học thuật</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 30px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="background-color: #e74c3c; padding: 20px; text-align: center;">
            <h2 style="color: #ffffff; margin: 0;">🚨 Giảng viên hủy đăng ký sinh hoạt học thuật!</h2>
        </div>

        <div style="padding: 30px;">
            <p>Kính gửi:{{ $giangVienLenLich->ho }} {{ $giangVienLenLich->ten }}</p>
            <p>Giảng viên đã hủy đăng ký tham gia sinh hoạt học thuật. Vui lòng kiểm tra thông tin dưới đây:</p>

            <div style="background-color: #f8f9fa; border-left: 5px solid #e74c3c; padding: 15px; margin: 20px 0;">
                <p><strong>👨‍💼 Giảng viên hủy đăng ký:</strong> {{ $giangVienHuyDangKy->ho }} {{ $giangVienHuyDangKy->ten }}</p>
                <p><strong>📅 Ngày hủy đăng ký:</strong> {{ \Carbon\Carbon::parse(now())->format('d/m/Y') }}</p>
                <p><strong>🏫 Khoa:</strong> {{ $lichBaoCao->boMon->khoa->tenKhoa ?? 'Chưa xác định' }}</p>
                <p><strong>📚 Bộ môn:</strong> {{ $lichBaoCao->boMon->tenBoMon ?? 'Chưa xác định' }}</p>
            </div>

            <h4 style="margin-bottom: 10px;">📝 Chủ đề báo cáo đã hủy đăng ký:</h4>
            <ul style="padding-left: 20px;">
                <li>{{ $lichBaoCao->chuDe }}</li>
            </ul>

            <p style="margin-top: 20px;">Vui lòng cập nhật thêm giảng viên phụ trách cho buổi sinh hoạt học thuật này.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('lichbaocao.index') }}" style="display: inline-block; padding: 12px 25px; background-color: #e74c3c; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    Xem chi tiết & Cập nhật
                </a>
            </div>

            <p style="margin-top: 30px;">Trân trọng,<br><strong>Hệ thống quản lý báo cáo học thuật</strong></p>
        </div>

        <div style="text-align: center; padding: 15px; background-color: #f1f1f1; font-size: 12px; color: #999;">
            © {{ date('Y') }} - Email được gửi tự động từ hệ thống. Vui lòng không trả lời email này.
        </div>
    </div>
</body>
</html>
