@extends('layouts.user')
@section('page-title', "Danh Sách Báo Cáo")
@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Danh Sách Biên Bản Đã Gửi</h5>
        <a href="{{ route('bienban.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Gửi Biên Bản
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="bienBanTable" width="100%">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Mã Biên Bản</th>
                        <th>Ngày Gửi</th>
                        <th>Chủ Đề Sinh Hoạt Học Thuật</th>
                        {{-- <th>File</th> --}}
                        <th>Hành Động</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#bienBanTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("bienban.index") }}', // Đảm bảo đúng URL
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'maBienBan', name: 'maBienBan'},
        { data: 'ngayNop', name: 'ngayNop' },
        { data: 'chuDe', name: 'chuDe'},
        { data: 'hanhdong', name: 'hanhdong', orderable: false, searchable: false }
    ],
    language: {
        searchPlaceholder: "Tìm kiếm...",
        lengthMenu: "Hiển thị _MENU_ dòng",
        processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'
    }
});

    });

    $(document).ready(function() {
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
                    document.getElementById(formId).submit(); // Submit form để xóa
                }
            });
        });
    });
</script>
@endsection
