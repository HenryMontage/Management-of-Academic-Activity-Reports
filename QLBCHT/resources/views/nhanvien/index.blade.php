
@extends('layouts.app')
@section('page-title', "PĐBCL")
@section('content')
<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Danh Sách PĐBCL</h5>
            <a href="{{ route('nhanvien.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm PĐBCL
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="pdbclTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>Ảnh</th>
                            <th>Họ Tên</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Quyền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#pdbclTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('nhanvien.index') }}",
            columns: [
                {data: 'anhDaiDien', name: 'anhDaiDien'},
                { 
                    data: null, 
                    name: 'ho_ten', 
                    render: function(data, type, row) {
                        return row.ho + ' ' + row.ten; //Ghép họ và tên trực tiếp trong datatable
                    }
                },
                {data: 'sdt', name: 'sdt'},
                {data: 'email', name: 'email'},
                {data: 'quyen', name: 'quyen'},
                {data: 'hanhdong', name: 'hanhdong', orderable: false, searchable: false}
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

