{{-- @extends('layouts.user')

@section('content')
<div class="container">
    <h3 class="mb-4">Danh sách biên bản đã xác nhận</h3>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse($bienBienBanCaos as $bienban)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <strong>Ngày xác nhận:</strong> {{ $bienban->update_at }}
                <span><strong>Trạng thái:</strong> {{ $bienban->trangThai }}</span>
            </div>
            <div class="card-body">
                <p><strong>Người gửi</strong> {{ $bienban->giangVien->ho}} {{ $bienban->giangVien->ten}}</p>
                <p><strong>Mã biên bản</strong> {{ $bienban->maBienBan}}</p>
                <p><strong>Chủ đề sinh hoạt:</strong> {{ $bienban->lichBaoCao->chuDe }}</p>
                <p><strong>Bộ môn:</strong> {{ $bienban->lichBaoCao->boMon->tenBoMon }}</p>
                <p><strong>Khoa:</strong> {{ $bienban->lichBaoCao->boMon->khoa->tenKhoa }}</p> 
                
            </div>
        </div>
    @empty
        <p>Không có biên bản nào đã xác nhận.</p>
    @endforelse
</div>
@endsection --}}


@extends('layouts.user')

@section('content')
<div class="container">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('xacnhan.index') }}" class="me-3" style="font-size: 30px; padding:5px;">
            <i class="fa-solid fa-circle-arrow-left"></i>
        </a> 
        <h3 class="mb-0">Biên Bản Đã Xác Nhận</h3>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($bienBanBaoCaos as $bienban)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <span><strong>Trạng thái:</strong> {{ $bienban->trangThai }}</span>
                        <a class="btn btn-sm btn-primary align-center" href="{{ asset($bienban->fileBienBan) }}" target="_blank">Tải về</a>
                    </div>
                    <div class="card-body">
                        <p><strong>Người gửi:</strong> {{ $bienban->giangVien->ho }} {{ $bienban->giangVien->ten }}</p>
                        <p><strong>Mã biên bản:</strong> {{ $bienban->maBienBan }}</p>
                        <p><strong>Chủ đề:</strong> {{ $bienban->lichBaoCao->chuDe }}</p>
                        <p><strong>Bộ môn:</strong> {{ $bienban->lichBaoCao->boMon->tenBoMon }}</p>
                        <p><strong>Khoa:</strong> {{ $bienban->lichBaoCao->boMon->khoa->tenKhoa }}</p>
                        <p><strong>Ngày xác nhận:</strong> {{ \Carbon\Carbon::parse($bienban->update_at)->format('d/m/Y') }}</p>
                        
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Không có biên bản nào đã xác nhận.</p>
        @endforelse
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center">
        {{ $bienBanBaoCaos->links() }}
    </div>
</div>
@endsection
