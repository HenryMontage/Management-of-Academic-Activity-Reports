@extends('layouts.app')
@section('page-title', "Quyền")
@section('content')


<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Danh Sách Quyền</h5>
        <a href="{{ route('quyen.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Quyền
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="quyenTable" width="100%">
                <thead class="thead-light">
                    <th>Mã Quyền</th>
                    <th>Tên Quyền</th>
                    <th>Nhóm Chức Năng Được Phép Truy Cập</th>
                    <th>Hành động</th>                                                 
            </tr>   
        </thead> 
    </table>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
      $(document).ready(function() {
        $('#quyenTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('quyen.index') }}",
            columns: [
                { data: 'maQuyen', name: 'maQuyen' , width: '120px'},
                { data: 'tenQuyen', name: 'tenQuyen' },
                { data: 'nhomRoute', name: 'nhomRoute' },
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
            e.preventDefault(); // Ngăn chặn hành động mặc định của nút
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
                    document.getElementById(formId).submit(); // Submit form bằng JavaScript
                }
            });
        });
    });
</script>
@endsection
