

@extends('layouts.user')

@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Danh Sách Phiếu Đăng Ký</h4>
            <a href="{{ route('dangkybaocao.create') }}" class="btn btn-outline-light" style="border-radius: 5px;border: 3px solid #fff;">Gửi Phiếu Đăng Ký</a>
        </div>
        <div class="form-body">
             @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row mb-4 justify-content-center">
                <form action="{{ route('dangkybaocao.index') }}" method="GET" 
                    class="d-flex flex-wrap align-items-center gap-2 justify-content-center" style="max-width: 100%;">
                    
                    <input type="text" name="keyword" 
                           class="form-control form-control-sm" 
                           placeholder="Nhập từ khóa (tên chủ đề, trạng thái, ngày gửi)..." 
                           value="{{ request('keyword') }}" 
                           style="width: 350px; height: 45px; min-width: 250px;">
                    
                    <button class="btn btn-primary" type="submit" style="height: 45px; min-width: 100px;">
                        Tìm kiếm
                    </button>
                    
                    <a href="{{ route('dangkybaocao.index') }}" class="btn btn-success" style="height: 45px; min-width: 100px; align-content: center;">
                        Làm mới
                    </a>
                </form>  
            </div>
            <div class="row">
                @forelse($dangKyBaoCaos as $dangKy)
                    @php
                        $statusColor = match($dangKy->trangThai) {
                            'Chờ Xác Nhận' => 'warning',
                            'Đã Xác Nhận' => 'primary',
                            'Từ Chối' => 'danger',
                            default => 'secondary',
                        };
                        $modalId = 'modal-' . $dangKy->maDangKyBaoCao;
                    @endphp
            
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100 border-{{ $statusColor }} border-top border-4">
                            <div class="card-body d-flex flex-column">
                                <div class="text-center mb-2">
                                    <i class="fas fa-file-alt fa-2x text-{{ $statusColor }}"></i>
                                </div>
                                <h6 class="card-title text-center">Chủ đề: {{ $dangKy->lichBaoCao->chuDe ?? '[Không rõ]' }}</h6>
                                <p class="card-text text-center text-muted mb-1">Ngày gửi: <strong>{{ \Carbon\Carbon::parse($dangKy->ngayDangKy)->format('d/m/Y') }}</strong></p>
                                <p class="card-text text-center text-muted">Trạng thái: <strong>{{ $dangKy->trangThai }}</strong></p>
                                
                                <div class="d-flex justify-content-center mt-auto">
                                    <button class="btn btn-outline-{{ $statusColor }}" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
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
                                <div class="modal-header bg-{{ $statusColor }} text-white">
                                    <h5 class="modal-title" id="{{ $modalId }}Label">Chi tiết phiếu đăng ký</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-1"><strong>Ngày đăng ký:</strong> {{ \Carbon\Carbon::parse($dangKy->ngayDangKy)->format('d/m/Y') }}</p>
                                    <p class="mb-1"><strong>Trạng thái:</strong> {{ $dangKy->trangThai }}</p>
                                    <p class="mb-1"><strong>Chủ đề:</strong> {{ $dangKy->lichBaoCao->chuDe ?? '[Không rõ]' }}</p>
                                    <p class="mb-1"><strong>Ngày/giờ sinh hoạt:</strong> {{ \Carbon\Carbon::parse($dangKy->lichBaoCao->ngayBaoCao)->format('d/m/Y') }} - {{ $dangKy->lichBaoCao->gioBaoCao }}</p>
                                    <p class="mb-1"><strong>Địa điểm:</strong> VP BM {{ $dangKy->lichBaoCao->boMon->tenBoMon ?? '' }}</p>
                                    <p class="mb-1"><strong>Bộ môn:</strong> {{ $dangKy->lichBaoCao->boMon->tenBoMon ?? '[Không rõ]' }}</p>
                                    <p class="mb-1"><strong>Khoa:</strong> {{ $dangKy->lichBaoCao->boMon->khoa->tenKhoa ?? '[Không rõ]' }}</p>
                                    <p class="mb-1"><strong>Danh sách báo cáo viên:</strong></p>
                                    <ul>
                                        @foreach($dangKy->baoCaos as $bc)
                                            <li>
                                                {{ $bc->giangVien->ho }} {{ $bc->giangVien->ten }} - 
                                                <a href="{{ $bc->duongDanFile }}" target="_blank">{{ $bc->tenBaoCao }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="modal-footer d-flex justify-content-center gap-2">
                                     <form action="{{ route('dangkybaocao.destroy', $dangKy->maDangKyBaoCao) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                            <i class="fas fa-trash-alt me-1"></i> Xoá
                                        </button>
                                    </form>
                                    <a href="{{ route('dangkybaocao.export', ['lich_id' => $dangKy->lichBaoCao->maLich]) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-file-export me-1"></i> Xuất PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="d-flex justify-content-center">
                    <h4>Không Có Phiếu Đăng Ký Nào</h4>
                </div>
                @endforelse
            
                <div class="d-flex justify-content-center mt-4">
                    {{ $dangKyBaoCaos->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
     $(document).ready(function() {
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let formId = $(this).data('form');
            const form = $(this).closest('form'); 
            Swal.fire({
                title: "Bạn có chắc chắn?",
                text: "Bạn sẽ không thể khôi phục lại dữ liệu này!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Vâng, xóa nó!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form trực tiếp
                }
            });
        });
    });
</script>
@endsection

