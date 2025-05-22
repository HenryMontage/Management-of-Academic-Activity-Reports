<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kết quả đăng ký báo cáo</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Kết quả đăng ký sinh hoạt học thuật</h2>

    <p>Xin chào {{ $baoCao->giangVien->ho }} {{ $baoCao->giangVien->ten }},</p>

    <p>Chúng tôi xin thông báo rằng báo cáo:</p>

    <blockquote style="border-left: 4px solid #ccc; padding-left: 10px;">
        <strong>{{ $baoCao->tenBaoCao }}</strong>
    </blockquote>

    <p><strong>không được đăng ký tổ chức sinh hoạt học thuật</strong> trong đợt đăng ký hiện tại.</p>

    <p>Xin vui lòng thu hồi để chuẩn bị và nộp lại trong các đợt đăng ký tiếp theo.</p>

    <p>Trân trọng,<br>
    Bộ phận quản lý chất lượng</p>
</body>
</html>
