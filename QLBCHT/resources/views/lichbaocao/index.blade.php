@extends('layouts.user')

<style>
    .modal-header .close {
        font-size: 1rem;
        color: black !important;
        opacity: 1;
    }
</style>
@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Danh Sách Lịch Sinh Hoạt Học Thuật</h5>
        @php 
            $guard = session('current_guard');
            $user = Auth::guard($guard)->user();
        @endphp
        
        {{-- @if($user->chucVu != 1)
        <a href="{{ route('lichbaocao.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Lịch 
        </a>
        @endif --}}
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
                        {{-- <th>#</th> --}}
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
<!-- Modal xem báo cáo -->
<div class="modal fade" id="baoCaoModal" tabindex="-1" role="dialog" aria-labelledby="baoCaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title" id="baoCaoModalLabel">Danh sách báo cáo</h5>
          {{-- <button type="button" class="close text-white" data-dismiss="modal" aria-label="Đóng">
            <span aria-hidden="true">&times;</span>
          </button> --}}
        </div>
        <div class="modal-body">
          <ul id="baoCaoList" class="list-group">
              <!-- Nội dung động -->
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
                // { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
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
@endsection
