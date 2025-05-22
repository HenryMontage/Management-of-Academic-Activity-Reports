@extends('layouts.user')

@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Phiếu Đăng Ký Chờ Xác Nhận</h4>
            <a href="{{ route('duyet.daduyet') }}" class="btn btn-outline-light" style="border-radius: 5px;border: 3px solid #fff;">Phiếu Đã Xác Nhận</a>
        </div>
        <div class="form-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
    
            <div class="row g-4">
                @forelse($dangKyBaoCaos as $dangKy)
                    @php
                        $statusColor = match($dangKy->trangThai) {
                            'Chờ xác nhận' => 'warning',
                            'Đã xác nhận' => 'success',
                            'Từ chối' => 'danger',
                            default => 'secondary',
                        };
                        $modalId = 'modal-' . $dangKy->maDangKyBaoCao;
                    @endphp
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100 border-warning border-top border-4">
                            <div class="card-body d-flex flex-column">
                                <div class="text-center mb-2">
                                    <i class="fas fa-file-alt fa-2x text-warning"></i>
                                </div>
                                <h6 class="card-title text-center">Đăng ký ngày {{ \Carbon\Carbon::parse($dangKy->ngayDangKy)->format('d/m/Y') }}</h6>
                                <p class="card-text text-center text-muted mb-0">Trạng thái: <strong>{{ $dangKy->trangThai }}</strong></p>
                                <p class="card-text text-center text-muted">Chủ đề: <strong>{{ $dangKy->lichBaoCao->chuDe }}</strong></p>
                                <div class="d-flex justify-content-center mt-auto">
                                    <button class="btn btn-outline-warning text-warning" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                                        <i class="fas fa-eye me-1"></i> Xem và xác nhận
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <!-- Modal -->
                    <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title" id="{{ $modalId }}Label">Chi tiết phiếu đăng ký</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-0 p-1"><strong>Ngày đăng ký:</strong> {{ \Carbon\Carbon::parse($dangKy->ngayDangKy)->format('d/m/Y') }}</p>
                                    <p class="mb-0 p-1"><strong>Trạng thái:</strong> {{ $dangKy->trangThai }}</p>
                                    <p class="mb-0 p-1"><strong>Chủ đề:</strong> {{ $dangKy->lichBaoCao->chuDe }}</p>
                                    <p class="mb-0 p-1"><strong>Ngày/giờ tổ chức sinh hoạt học thuật:</strong> {{ \Carbon\Carbon::parse($dangKy->lichBaoCao->ngayBaoCao)->format('d/m/Y') }} - {{ $dangKy->lichBaoCao->gioBaoCao }}</p>
                                    <p class="mb-0 p-1"><strong>Bộ môn:</strong> {{ $dangKy->lichBaoCao->boMon->tenBoMon }}</p>
                                    <p class="mb-0 p-1"><strong>Khoa:</strong> {{ $dangKy->lichBaoCao->boMon->khoa->tenKhoa }}</p>
                                    <p class="mb-0 p-1"><strong>Danh sách báo cáo viên - tên báo cáo:</strong></p>
                                    <ul>
                                        @foreach($dangKy->baoCaos as $bc) 
                                            <li>{{ $bc->giangVien->ho }} {{ $bc->giangVien->ten }} - {{ $bc->tenBaoCao }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                
                                    <form action="{{ route('duyet.duyet', $dangKy->maDangKyBaoCao) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check-circle me-1"></i> Xác nhận
                                        </button>
                                    </form>
                                    <form action="{{ route('duyet.tuchoi', $dangKy->maDangKyBaoCao) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-times-circle me-1"></i> Từ chối
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <h4>Không có phiếu đăng ký nào chờ xác nhận.</h4>
                @endforelse
            
                <div class="d-flex justify-content-center mt-4">
                    {{ $dangKyBaoCaos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
