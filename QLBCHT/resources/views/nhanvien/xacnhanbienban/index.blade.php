

@extends('layouts.user')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Biên Bản Chờ Xác Nhận</h3>
        <a href="{{ route('xacnhan.daxacnhan') }}" class="btn btn-primary">Biên Bản Đã Xác Nhận</a>
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
                    </div>
                    <div class="card-body">
                        <p><strong>Người gửi:</strong> {{ $bienban->giangVien->ho }} {{ $bienban->giangVien->ten }}</p>
                        <p><strong>Mã biên bản:</strong> {{ $bienban->maBienBan }}</p>
                        <p><strong>Chủ đề:</strong> {{ $bienban->lichBaoCao->chuDe }}</p>
                        <p><strong>Bộ môn:</strong> {{ $bienban->lichBaoCao->boMon->tenBoMon }}</p>
                        <p><strong>Khoa:</strong> {{ $bienban->lichBaoCao->boMon->khoa->tenKhoa }}</p>
                        <p><strong>Ngày gửi:</strong> {{ \Carbon\Carbon::parse($bienban->ngayNop)->format('d/m/Y') }}</p>
                        
                        <form action="{{ route('xacnhan.xacnhan', $bienban->maBienBan) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Xác nhận</button>
                        </form>

                        <form action="{{ route('xacnhan.tuchoi', $bienban->maBienBan) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Từ chối</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Không có đăng ký nào chờ xác nhận.</p>
        @endforelse
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center">
        {{ $bienBanBaoCaos->links() }}
    </div>
</div>
@endsection

