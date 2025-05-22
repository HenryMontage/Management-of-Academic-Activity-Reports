
@extends('layouts.user')

@section('content')

<div class="fixed-container">
    <div class="form-container">
        <div class="form-header d-flex align-items-center">
            <a href="{{ route('xacnhan.index') }}" class="me-3" style="font-size: 30px; padding:5px;color:#fff;">
                <i class="fa-solid fa-circle-arrow-left"></i>
            </a> 
            <h3 class="mb-0">Biên Bản Đã Xác Nhận</h3>
        </div>
        <div class="form-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row g-4">
            @forelse($bienBanBaoCaos as $bienban)
                @php
                    $modalId = 'modal-xacnhan-' . $bienban->maBienBan;
                @endphp
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 border-success border-top border-4">
                        <div class="card-body d-flex flex-column">
                            <div class="text-center mb-2">
                                <i class="fas fa-file-alt fa-2x text-success"></i>
                            </div>
                            <h6 class="card-title text-center">Ngày xác nhận: {{ \Carbon\Carbon::parse($bienban->update_at)->format('d/m/Y') }}</h6>
                            <p class="card-text text-center text-muted mb-0">Trạng thái: <strong>{{ $bienban->trangThai }}</strong></p>
                            <p class="card-text text-center text-muted">Chủ đề: <strong>{{ $bienban->lichBaoCao->chuDe }}</strong></p>
                            <div class="d-flex justify-content-center mt-auto">
                                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                                    <i class="fas fa-eye me-1"></i> Xem chi tiết
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Modal -->
                <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="{{ $modalId }}Label">Chi tiết biên bản sinh hoạt học thuật</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-0 p-1"><strong>Mã biên bản:</strong> {{ $bienban->maBienBan }}</p>
                                <p class="mb-0 p-1"><strong>Chủ đề:</strong> {{ $bienban->lichBaoCao->chuDe }}</p>
                                <p class="mb-0 p-1"><strong>Ngày gửi:</strong> {{ \Carbon\Carbon::parse($bienban->ngayNop)->format('d/m/Y') }}</p>
                                <p class="mb-0 p-1"><strong>Trạng thái:</strong> {{ $bienban->trangThai }}</p>
                                <p class="mb-0 p-1"><strong>Ngày xác nhận:</strong> {{ \Carbon\Carbon::parse($bienban->update_at)->format('d/m/Y') }}</p>
                                <p class="mb-0 p-1"><strong>Người gửi:</strong> {{ $bienban->giangVien->ho }} {{ $bienban->giangVien->ten }}</p>
                                <p class="mb-0 p-1"><strong>Ngày/giờ tổ chức:</strong> {{ \Carbon\Carbon::parse($bienban->lichBaoCao->ngayBaoCao)->format('d/m/Y') }} - {{ $bienban->lichBaoCao->gioBaoCao }}</p>
                                <p class="mb-0 p-1"><strong>Bộ môn:</strong> {{ $bienban->lichBaoCao->boMon->tenBoMon }}</p>
                                <p class="mb-0 p-1"><strong>Khoa:</strong> {{ $bienban->lichBaoCao->boMon->khoa->tenKhoa }}</p>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <a href="{{ asset($bienban->fileBienBan) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download me-1"></i> Tải Biên Bản
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <h4 class="text-center">Không có biên bản nào chờ xác nhận.</h4>
            @endforelse
        
            <div class="d-flex justify-content-center mt-4">
                {{ $bienBanBaoCaos->links() }}
            </div>
        </div>
        </div>
    </div>
</div>

@endsection
