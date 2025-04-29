<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phiếu đăng ký báo cáo</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        td, th { border: 1px solid #000; padding: 5px; text-align: left; }
        .center { text-align: center; }
    </style>
</head>
<body>

<div class="center">
    <strong>TRƯỜNG ĐẠI HỌC NHA TRANG</strong><br>
    <h3>PHIẾU ĐĂNG KÝ SINH HOẠT HỌC THUẬT</h3>
    <p>Lần thứ {{ $lich->lanBaoCao ?? '5' }} – năm học {{ $lich->namHoc ?? '2024-2025' }}</p>
</div>

<p><strong>Kính gửi:</strong> Phòng Đảm bảo chất lượng và Khảo thí</p>

<p>
    <strong>Bộ môn:</strong> {{ $lich->boMon->tenBoMon }}<br>
    <strong>Khoa:</strong> {{ $lich->boMon->khoa->tenKhoa }}<br>
    <strong>Giờ/ngày tổ chức:</strong> {{ $lich->gioBaoCao }}, {{ \Carbon\Carbon::parse($lich->ngayBaoCao)->format('d/m/Y') }}<br>
    <strong>Địa điểm:</strong> VP BM {{ $lich->boMon->tenBoMon }}
</p>

<p><strong>Họ và tên báo cáo viên và chủ đề báo cáo:</strong></p>

<table>
    <thead>
        <tr>
            <th>STT</th>
            <th>Họ và tên</th>
            <th>Chủ đề báo cáo</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        {{-- @foreach($lich->giangVienPhuTrach as $gv)
            @foreach($gv->baoCao as $bc)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $gv->ho }} {{ $gv->ten }}</td>
                    <td>{{ $bc->tenBaoCao }}</td>
                </tr>
            @endforeach
        @endforeach --}}

        @foreach($dangKyBaoCaos as $dk)
            @foreach($dk->baoCaos as $bc)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $bc->giangVien->ho }} {{ $bc->giangVien->ten }}</td>
                    <td>{{ $bc->tenBaoCao }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

<br><br>
<div style="text-align: right;">
    <p><strong>Trưởng Bộ môn</strong></p><br><br><br>
    <p><strong>{{ $lich->giangVienPhuTrach->first()->ten ?? 'Nguyễn Đình Hưng' }}</strong></p>
</div>

</body>
</html>
