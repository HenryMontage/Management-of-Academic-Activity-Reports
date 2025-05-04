@extends('layouts.user')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Phiếu Đăng Ký Chờ Xác Nhận</h3>
        <a href="{{ route('duyet.daduyet') }}" class="btn btn-primary">Phiếu Đã Xác Nhận</a>
    </div>
    

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="row">
        @forelse($dangKyBaoCaos as $dangKy)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <span><strong>Ngày đăng ký:</strong> {{ \Carbon\Carbon::parse($dangKy->ngayDangKy)->format('d/m/Y') }}</span>
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
    
                        <form action="{{ route('duyet.duyet', $dangKy->maDangKyBaoCao) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">Xác nhận</button>
                        </form>
    
                        <form action="{{ route('duyet.tuchoi', $dangKy->maDangKyBaoCao) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger">Từ chối</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>Không có đăng ký nào chờ xác nhận.</p>
        @endforelse
        <div class="d-flex justify-content-center">
            {{ $dangKyBaoCaos->links() }}
        </div>
        
    </div>
    
</div>
@endsection
