
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo kết quả xác nhận biên bản sinh hoạt học thuật</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 30px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="background-color: #2c3e50; padding: 20px; text-align: center;">
            <h2 style="color: #ffffff; margin: 0;">📢 Kết quả xác nhận biên bản sinh hoạt học thuật!</h2>
        </div>

        <div style="padding: 30px;">
            <p>Kính gửi: Quý thầy/cô!</p>

            <div style="background-color: #f8f9fa; border-left: 5px solid #3498db; padding: 15px; margin: 20px 0;">
                @php
                $guard = session('current_guard');
                $user = Auth::guard($guard)->user();
            @endphp
                <p><strong>👨‍💼 Người xác nhận:</strong> {{ $user->ho }} {{ $user->ten }}</p>
                <p><strong>📄 Mã Biên Bản:</strong> {{ $bienban->maBienBan}}</p>
                <p><strong>🏫 Chủ đề sinh hoạt học thuật:</strong> {{ $bienban->lichBaoCao->chuDe }}</p>
                <p><strong>📅 Ngày xác nhận:</strong> {{ \Carbon\Carbon::parse($bienban->updated_at)->format('d/m/Y') }}</p>
                <p><strong>✅ Trạng thái:</strong> <span style="color: {{ $bienban->trangThai == 'Đã xác nhận' ? '#27ae60' : '#e74c3c' }}; font-weight: bold;">
                    {{ $bienban->trangThai }}
                </span>
                </p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('bienban.index') }}" style="display: inline-block; padding: 12px 25px; background-color: #27ae60; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    Xem chi tiết 
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
