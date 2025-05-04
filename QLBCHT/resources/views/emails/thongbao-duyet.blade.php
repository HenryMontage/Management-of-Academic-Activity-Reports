<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo kết quả duyệt báo cáo</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 30px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="background-color: #2c3e50; padding: 20px; text-align: center;">
            <h2 style="color: #ffffff; margin: 0;">📢 Kết quả xác nhận phiếu đăng ký học thuật</h2>
        </div>

        <div style="padding: 30px;">
            <p>Kính gửi: {{ $dangKy->baoCaos->first()->giangVien->ho }} {{ $dangKy->baoCaos->first()->giangVien->ten }}</p>
            <p>Phiếu đăng ký học thuật của Thầy/Cô đã được xem xét và có kết quả như sau:</p>

            <div style="background-color: #f8f9fa; border-left: 5px solid #3498db; padding: 15px; margin: 20px 0;">
                @php
                    $guard = session('current_guard');
                    $user = Auth::guard($guard)->user();
                @endphp
                <p><strong>👨‍💼 Người xác nhận:</strong> {{ $user->ho }} {{ $user->ten }}</p>
                <p><strong>📅 Ngày xác nhận:</strong> {{ \Carbon\Carbon::parse($dangKy->updated_at)->format('d/m/Y') }}</p>
                <p><strong>📝 Chủ đề:</strong> {{ $dangKy->lichBaoCao->chuDe }}</p>
                <p><strong>✅ Trạng thái:</strong> <span style="color: {{ $dangKy->trangThai == 'Đã xác nhận' ? '#27ae60' : '#e74c3c' }}; font-weight: bold;">
                    {{ $dangKy->trangThai }}
                </span>
                </p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('dangkybaocao.index') }}" style="display: inline-block; padding: 12px 25px; background-color: #2c3e50; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    Xem chi tiết trên hệ thống
                </a>
            </div>

            <p style="margin-top: 30px;">Trân trọng,<br><strong>Phòng Đảm bảo chất lượng và Khảo thí</strong></p>
        </div>

        <div style="text-align: center; padding: 15px; background-color: #f1f1f1; font-size: 12px; color: #999;">
            © {{ date('Y') }} - Email được gửi tự động từ hệ thống. Vui lòng không trả lời email này.
        </div>
    </div>
</body>
</html>

