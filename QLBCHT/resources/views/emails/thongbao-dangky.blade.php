{{-- <h2>Thông báo mới!</h2>
<p>Giảng viên đã đăng ký báo cáo học thuật.</p>
<p>Vui lòng truy cập hệ thống để kiểm tra và duyệt.</p> --}}

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo đăng ký sinh hoạt học thuật</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 30px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="background-color: #2c3e50; padding: 20px; text-align: center;">
            <h2 style="color: #ffffff; margin: 0;">📢 Có phiếu đăng ký sinh học thuật mới!</h2>
        </div>

        <div style="padding: 30px;">
            <p>Kính gửi: Phòng Đảm bảo chất lượng và Khảo thí</p>
            <p>Có phiếu đăng ký sinh học thuật mới! Vui lòng kiểm tra và duyệt trong hệ thống.</p>

            <div style="background-color: #f8f9fa; border-left: 5px solid #3498db; padding: 15px; margin: 20px 0;">
                <p><strong>👤 Giảng viên:</strong> {{ $dangKy->baoCaos->first()->giangVien->ho }} {{ $dangKy->baoCaos->first()->giangVien->ten }}</p>
                <p><strong>📅 Ngày đăng ký:</strong> {{ \Carbon\Carbon::parse($dangKy->ngayDangKy)->format('d/m/Y') }}</p>
                <p><strong>🏫 Khoa:</strong> {{ $dangKy->lichBaoCao->boMon->khoa->tenKhoa ?? 'Chưa xác định' }}</p>
                <p><strong>📚 Bộ môn:</strong> {{ $dangKy->lichBaoCao->boMon->tenBoMon ?? 'Chưa xác định' }}</p>
            </div>

            <h4 style="margin-bottom: 10px;">📝 Chủ đề báo cáo đã đăng ký:</h4>
            <ul style="padding-left: 20px;">
                {{-- @foreach ($dangKy->baoCaos as $baoCao)
                    <li>{{ $baoCao->tenBaoCao }}</li>
                @endforeach --}}
                {{ $dangKy->lichBaoCao->chuDe }}
            </ul>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('duyet.index') }}" style="display: inline-block; padding: 12px 25px; background-color: #27ae60; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    Xem chi tiết & Duyệt
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
