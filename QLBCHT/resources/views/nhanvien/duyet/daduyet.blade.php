@extends('layouts.user')

@section('content')
<div class="container">
    <h3 class="mb-4">Danh sách đăng ký báo cáo đã duyệt</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse($dangKyBaoCaos as $dangKy)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <strong>Ngày đăng ký:</strong> {{ $dangKy->ngayDangKy }}
                <span><strong>Trạng thái:</strong> {{ $dangKy->trangThai }}</span>
            </div>
            <div class="card-body">
                <p><strong>Lịch tổ chức sinh hoạt học thuật:</strong> {{ $dangKy->lichBaoCao->ngayBaoCao }} {{ $dangKy->lichBaoCao->gioBaoCao }}</p>
                <p><strong>Chủ đề sinh hoạt:</strong> {{ $dangKy->lichBaoCao->chuDe }}</p>
                <p><strong>Bộ môn:</strong> {{ $dangKy->lichBaoCao->boMon->tenBoMon }}</p>
                <p><strong>Khoa:</strong> {{ $dangKy->lichBaoCao->boMon->khoa->tenKhoa }}</p>
                <p><strong>Họ và tên báo cáo viên và tên báo cáo</strong></p>
                <ul>
                    @foreach($dangKy->baoCaos as $bc)
                        <li>{{ $bc->giangVien->ho }} {{ $bc->giangVien->ten }} - {{ $bc->tenBaoCao }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @empty
        <p>Không có đăng ký nào đã duyệt.</p>
    @endforelse
</div>
@endsection
