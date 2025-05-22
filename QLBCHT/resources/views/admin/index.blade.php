

@extends('layouts.app')
@section('page-title', "Quản Trị Viên")
@section('content')
<div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Danh Sách Quản Trị Viên</h5>
            <a href="{{ route('admin.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm Quản Trị Viên
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="adminTable" width="100%">
                    <thead class="thead-light">
                        <tr>
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
        let table = $('#adminTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.index') }}",
            columns: [
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
</script>
@endsection
