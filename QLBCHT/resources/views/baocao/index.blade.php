@extends('layouts.user')
@section('page-title', "Danh Sách Báo Cáo")
@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="fas fa-file-alt me-2"></i>Danh Sách Báo Cáo</h4>
            <a href="{{ route('baocao.create') }}" class="btn btn-outline-light" style="border-radius: 5px;border: 3px solid #fff;">Nộp Báo Cáo</a>
        </div>
        <div class="form-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="row mb-4 justify-content-center">
                <form action="{{ route('baocao.index') }}" method="GET" 
                      class="d-flex flex-wrap align-items-center gap-2 justify-content-center">
                    <input type="text" name="keyword"
                           class="form-control form-control-sm"
                           placeholder="Nhập từ khóa (chủ đề, ngày nộp(Y-m-d), định dạng)..."
                           value="{{ request('keyword') }}"
                           style="width: 350px; height: 45px;">
                    <button class="btn btn-primary" type="submit" style="height: 45px;">Tìm kiếm</button>
                    <a href="{{ route('baocao.index') }}" class="btn btn-success" style="height: 45px;min-width: 100px; align-content: center;">Làm mới</a>
                </form>
            </div>
            <div class="row">              
                @forelse($baoCaos as $bc)
                    @php
                        $modalId = 'modal-bc-' . $bc->maBaoCao;
                    @endphp
    
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100 border-primary border-top border-4">
                            <div class="card-body d-flex flex-column">
                                <div class="text-center mb-2">
                                    <i class="fas fa-file-alt fa-2x text-primary"></i>
                                </div>
                                <h6 class="card-title text-center">Tên báo cáo: {{ $bc->tenBaoCao }}</h6>
                                <p class="card-text text-center text-muted mb-1">Ngày nộp: <strong>{{ \Carbon\Carbon::parse($bc->update_at)->format('d/m/Y H:i') }}</strong></p>
                                <p class="card-text text-center text-muted">Định dạng: <strong>{{ $bc->dinhDang }}</strong></p>
    
                                <div class="d-flex justify-content-center mt-auto">
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
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
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="{{ $modalId }}Label">Chi tiết báo cáo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Chủ đề:</strong> {{ $bc->lichBaoCao->chuDe ?? 'Không rõ' }}</p>
                                    <p><strong>Tên báo cáo:</strong> {{ $bc->tenBaoCao }}</p>
                                    <p><strong>Ngày nộp:</strong> {{ \Carbon\Carbon::parse($bc->ngayNop)->format('d/m/Y H:i') }}</p>
                                    <p><strong>Định dạng:</strong> {{ $bc->dinhDang }}</p>
                                    <p><strong>Tóm tắt:</strong> {!! nl2br(e($bc->tomTat)) !!}</p>
                                </div>
                                <div class="modal-footer d-flex justify-content-center gap-2">
                                    <form action="{{ route('baocao.destroy', $bc->maBaoCao) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                            <i class="fas fa-trash-alt me-1"></i> Xoá
                                        </button>
                                    </form>
                                    <a href="{{ $bc->duongDanFile }}" target="_blank" class="btn btn-success btn-sm">
                                        <i class="fas fa-download me-1"></i> Tải File
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="d-flex justify-content-center">
                        <h4>Không Có Báo Cáo Nào</h4>
                    </div>
                @endforelse
                <div class="d-flex justify-content-center mt-4">
                    {{ $baoCaos->links() }}
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


