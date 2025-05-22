{{-- @extends('layouts.user')


@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Danh Sách Lịch Sinh Hoạt Học Thuật</h5>
        @php 
            $guard = session('current_guard');
            $user = Auth::guard($guard)->user();
        @endphp
        @if($guard === 'giang_viens' && in_array($user->chucVuObj->tenChucVu, ['Trưởng Bộ Môn', 'Trưởng Khoa']))
        <a href="{{ route('lichbaocao.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Lịch 
        </a>
    @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="lichBaoCaoTable" width="100%">
                <thead class="thead-light">
                    <tr>

                        <th>Chủ Đề</th>
                        <th>Ngày Báo Cáo</th>
                        <th>Giờ Báo Cáo</th>
                        <th>Hạn Ngày Nộp</th>
                        <th>Hạn Giờ Nộp</th>
                        <th>Bộ Môn</th>
                        <th>Giảng Viên Phụ Trách</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="baoCaoModal" tabindex="-1" role="dialog" aria-labelledby="baoCaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title" id="baoCaoModalLabel">Danh sách báo cáo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">
          <ul id="baoCaoList" class="list-group">

          </ul>
          <nav>
              <ul id="pagination" class="pagination justify-content-center mt-2"></ul>
          </nav>
        </div>
       
      </div>
    </div>
  </div>
  
@endsection

@section('script')

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        let table = $('#lichBaoCaoTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('lichbaocao.index') }}",
            columns: [
               
                { data: 'chuDe', name: 'chuDe' },
                { data: 'ngayBaoCao', name: 'ngayBaoCao' },
                { data: 'gioBaoCao', name: 'gioBaoCao' },
                { data: 'hanNgayNop', name: 'hanNgayNop' },
                { data: 'hanGioNop', name: 'hanGioNop' },
                { data: 'boMon', name: 'boMon' },
                { data: 'giangVienPhuTrach', name: 'giangVienPhuTrach' },
                { data: 'hanhdong', name: 'hanhdong', orderable: false, searchable: false }
            ],
            language: {
                searchPlaceholder: "Tìm kiếm...",
                lengthMenu: "Hiển thị _MENU_ dòng",
                processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'
            }
        });
    });

    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let formId = $(this).data('form');
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
                document.getElementById(formId).submit();
            }
        });
    });


    $(document).on('click', '.btn-view-bc', function() {
    const maLich = $(this).data('id');
    $('#baoCaoList').html('<li class="list-group-item">Đang tải...</li>');

    $('#baoCaoModal').modal('show');

    $.get('/lichbaocao/' + maLich + '/baocao', function(data) {
    if (data.length === 0) {
        $('#baoCaoList').html('<li class="list-group-item text-muted">Không có báo cáo nào.</li>');
        $('#pagination').html('');
        return;
    }

    const itemsPerPage = 5;
    let currentPage = 1;
    const totalPages = Math.ceil(data.length / itemsPerPage);

    function renderPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageItems = data.slice(start, end).map(bc => 
            `<li class="list-group-item">
                ${bc.giangVien} - 
                <a href="${bc.duongDanFile}" download target="_blank">${bc.tenBaoCao}</a>
            </li>`
        );
        $('#baoCaoList').html(pageItems.join(''));
    }

    function renderPagination() {
        let paginationHtml = '';
        for (let i = 1; i <= totalPages; i++) {
            paginationHtml += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `;
        }
        $('#pagination').html(paginationHtml);
    }

    $(document).off('click', '#pagination a').on('click', '#pagination a', function(e) {
        e.preventDefault();
        currentPage = parseInt($(this).data('page'));
        renderPage(currentPage);
        renderPagination();
    });

    renderPage(currentPage);
    renderPagination();
});

});

</script>
@endsection --}}

@extends('layouts.user')

@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="fa-solid fa-calendar-days me-2"></i>Danh Sách Lịch</h4>
            @php 
            $guard = session('current_guard');
            $user = Auth::guard($guard)->user();
            @endphp
            @if($guard === 'giang_viens' && in_array($user->chucVuObj->tenChucVu, ['Trưởng Bộ Môn', 'Trưởng Khoa']))
            <a href="{{ route('lichbaocao.create') }}" class="btn btn-outline-light" style="border-radius: 5px;border: 3px solid #fff;">Thêm Lịch </a>
            @endif
        </div>
        <div class="form-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="row mb-4 justify-content-center">
                    <form action="{{ route('lichbaocao.index') }}" method="GET" 
                        class="d-flex flex-wrap align-items-center gap-2 justify-content-center" style="max-width: 100%;">
                        
                        <input type="text" name="keyword" 
                            class="form-control form-control-sm" 
                            placeholder="Nhập từ khóa (chủ đề, thời gian, giảng viên, bộ môn...)"
                            value="{{ request('keyword') }}" 
                            style="width: 350px; height: 45px; min-width: 250px;">
                        
                        <button class="btn btn-primary" type="submit" style="height: 45px; min-width: 100px;">
                            Tìm kiếm
                        </button>
                        
                        <a href="{{ route('lichbaocao.index') }}" class="btn btn-success" style="height: 45px; min-width: 100px; align-content: center;">
                            Làm mới
                        </a>
                    </form>  
                </div>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @forelse ($dsLichBaoCao as $lich)
                        @php
                            $modalId = 'modal-' . $lich->maLich;
                        @endphp
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm h-100 border-primary border-top border-4">
                                <div class="card-body d-flex flex-column">
                                    <div class="text-center mb-2">
                                        <i class="fa-solid fa-calendar-days fa-2x text-primary"></i>
                                    </div>
                                    <h6 class="card-title text-center">Chủ đề: {{ $lich->chuDe }}</h6>
                                    <h6 class="card-text text-center">Ngày/giờ tổ chức: {{ $lich->ngayBaoCao }}  {{ $lich->gioBaoCao }}</h6>
                                    <h6 class="card-text text-center">Hạn ngày/giờ nộp báo cáo:{{ $lich->hanNgayNop }}  {{ $lich->hanGioNop }}</h6>
                                    <h6 class="card-text text-center">
                                        Giảng viên phụ trách:
                                        {{ $lich->giangVienPhuTrach->map(fn($gv) => $gv->ho . ' ' . $gv->ten)->join(', ') }}
                                    </h6>
                                    
                                    <div class="d-flex justify-content-center gap-2 mt-auto">
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                                            <i class="fas fa-eye me-1"></i> Xem chi tiết
                                        </button>
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-bcn-{{ $lich->maLich }}">
                                            <i class="fas fa-file-alt me-1"></i> Báo cáo đã nộp
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Báo cáo đã nộp -->
                        <div class="modal fade" id="modal-bcn-{{ $lich->maLich }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title text-white">Danh sách báo cáo đã nộp</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if($lich->baoCaos->isEmpty())
                                            <div class="alert alert-info">Chưa có báo cáo nào được nộp cho lịch này.</div>
                                        @else
                                            <ul class="list-group">
                                                <h6>Giảng viên - tên báo cáo</h6>
                                                @foreach($lich->baoCaos as $bc)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $bc->giangVien->ho }} {{ $bc->giangVien->ten }}</strong>
                                                            - {{ $bc->tenBaoCao }}
                                                        </div>
                                                        <div>
                                                            @if($bc->duongDanFile)
                                                            <a style="min-width: 30px" href="{{ asset($bc->duongDanFile) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-download me-1"></i>
                                                            </a>
                                                            @else
                                                                <span class="text-muted">Không có file</span>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        <nav>
                                            <ul id="pagination" class="pagination justify-content-center mt-2"></ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Modal Chi tiết --}}
                        <div class="modal fade" id="{{ $modalId }}" aria-labelledby="{{ $modalId }}Label" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title text-white">Chi tiết lịch báo cáo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-1"><strong>Chủ đề:</strong> {{ $lich->chuDe }}</p>
                                        <p class="mb-1"><strong>Ngày báo cáo:</strong> {{ $lich->ngayBaoCao }}</p>
                                        <p class="mb-1"><strong>Giờ báo cáo:</strong> {{ $lich->gioBaoCao }}</p>
                                        <p class="mb-1"><strong>Hạn nộp ngày:</strong> {{ $lich->hanNgayNop }}</p>
                                        <p class="mb-1"><strong>Hạn nộp giờ:</strong> {{ $lich->hanGioNop }}</p>
                                        <p class="mb-1"><strong>Bộ môn:</strong> {{ $lich->boMon->tenBoMon ?? 'Chưa có' }}</p>
                                        <p class="mb-1"><strong>Giảng viên phụ trách:</strong><br>
                                            @foreach($lich->giangVienPhuTrach as $gv)
                                                - {{ $gv->ho }} {{ $gv->ten }}<br>
                                            @endforeach
                                        </p>                            
                                    </div>

                                    @if($guard === 'giang_viens' && in_array($user->chucVuObj->tenChucVu, ['Trưởng Bộ Môn', 'Trưởng Khoa']))
                                        <div class="modal-footer d-flex justify-content-center gap-2">
                                            <form action="{{ route('lichbaocao.edit', $lich->maLich) }}">

                                                <button type="submit" class="btn btn-warning btn-sm text-white">
                                                    <i class="fas fa-edit me-1 text-white"></i> Sửa
                                                </button>
                                            </form>
                                            <form action="{{ route('lichbaocao.destroy', $lich->maLich) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                                    <i class="fas fa-trash-alt me-1"></i> Xoá
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <div class="alert alert-info">Không tìm thấy lịch báo cáo phù hợp.</div>
                        </div>
                    @endforelse
                    
                    </div>
                    </div>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $dsLichBaoCao->links() }}
                    </div>
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
    setTimeout(() => {
        const success = document.getElementById('alert-success');
        const error = document.getElementById('alert-danger');
        if (success) success.style.display = 'none';
        if (error) error.style.display = 'none';
    }, 3000); // 3000ms = 3 giây
    

</script>
@endsection
