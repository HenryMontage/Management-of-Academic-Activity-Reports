{{-- @extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <h1>Danh sách Chức Vụ</h1>
    <a href="{{ route('chucvu.create') }}" class="btn btn-success">Thêm Chức Vụ</a>
    <table class="table table-hover" id="myTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã Chức Vụ</th>
                <th>Tên Chức Vụ</th>
                <th>Quyền</th>
                <th>Hành động</th>                                                  
            </tr>   
        </thead> 
        <tbody>
            @foreach($chucVus as $chucVu)
                <tr>
                    <td>{{ $loop->iteration }}</td>   
                    <td>{{ $chucVu->maChucVu }}</td> 
                    <td>{{ $chucVu->tenChucVu }}</td> 
                    <td>{{ $chucVu->quyen ? $chucVu->quyen->tenQuyen : 'Không' }}</td> 
                    <td>
                        <a href="{{ route('chucvu.edit', $chucVu->maChucVu) }}" class="btn btn-warning">Sửa</a>
                        <form id="deleteForm{{ $chucVu->maChucVu }}" action="{{ route('chucvu.destroy', $chucVu->maChucVu) }}" method="POST" style="display:inline;">
                            @method('DELETE')
                            @csrf
                        </form>
                        <button data-form="deleteForm{{ $chucVu->maChucVu }}" class="btn btn-delete btn-danger">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}

@extends('layouts.app')
@section('page-title', "Chức Vụ")
@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Danh Sách Chức Vụ</h5>
        <a href="{{ route('chucvu.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Chức Vụ
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="chucVuTable" width="100%">
                <thead class="thead-light">
                <th>#</th>
                <th>Mã Chức Vụ</th>
                <th>Tên Chức Vụ</th>
                <th>Quyền</th>
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
        $('#chucVuTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("chucvu.index") }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'maChucVu', name: 'maChucVu' },
                { data: 'tenChucVu', name: 'tenChucVu' },
                { data: 'quyen', name: 'quyen' },
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
