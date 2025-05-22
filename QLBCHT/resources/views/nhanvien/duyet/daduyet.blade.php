@extends('layouts.user')

@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header d-flex align-items-center">
            <a href="{{ route('duyet.index') }}" class="me-3" style="font-size: 30px; padding:5px;color:#fff;">
                <i class="fa-solid fa-circle-arrow-left"></i>
            </a> 
            <h3 class="mb-0">Phiếu Đăng Ký Đã Xác Nhận</h3>
        </div>
        <div class="form-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row g-4">
                @forelse($dangKyBaoCaos as $dangKy)
                    @php
                        $modalId = 'modal-xacnhan-' . $dangKy->maDangKyBaoCao;
                    @endphp
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100 border-success border-top border-4">
                            <div class="card-body d-flex flex-column">
                                <div class="text-center mb-2">
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                </div>
                                <h6 class="card-title text-center">Ngày xác nhận: {{ \Carbon\Carbon::parse($dangKy->updated_at)->format('d/m/Y') }}</h6>
                                <p class="card-text text-center text-muted mb-0">Trạng thái: <strong>{{ $dangKy->trangThai }}</strong></p>
                                <p class="card-text text-center text-muted">Chủ đề: <strong>{{ $dangKy->lichBaoCao->chuDe }}</strong></p>
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
                                    <h5 class="modal-title" id="{{ $modalId }}Label">Chi tiết phiếu đã xác nhận</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-0 p-1"><strong>Ngày đăng ký:</strong> {{ \Carbon\Carbon::parse($dangKy->ngayDangKy)->format('d/m/Y') }}</p>
                                    <p class="mb-0 p-1"><strong>Ngày xác nhận:</strong> {{ \Carbon\Carbon::parse($dangKy->updated_at)->format('d/m/Y') }}</p>
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
                                {{-- <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                @empty
                    <h4>Không có phiếu đăng ký nào đã xác nhận.</h4>
                @endforelse

                <div class="d-flex justify-content-center mt-4">
                    {{ $dangKyBaoCaos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
