{{-- @extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <h1>Danh sách Khoa</h1>
    <a href="{{ route('khoa.create') }}" class="btn btn-success">Thêm Khoa</a>
    <table class="table table-hover" id="myTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã Khoa</th>
                <th>Tên Khoa</th>
                <th>Trưởng Khoa</th>
                <th>Hành động</th>                                                  
            </tr>   
        </thead> 
        <tbody>
            @foreach($khoas as $khoa)
                <tr>
                    <td>{{ $loop->iteration }}</td>   
                    <td>{{ $khoa->maKhoa }}</td> 
                    <td>{{ $khoa->tenKhoa }}</td> 
                    <td>
                        {{ optional($khoa->truong_Khoa)->ho && optional($khoa->truong_Khoa)->ten 
                            ? optional($khoa->truong_Khoa)->ho . ' ' . optional($khoa->truong_Khoa)->ten 
                            : 'Không' 
                        }}
                    </td>
                    
                    <td>
                        <a href="{{ route('khoa.edit', $khoa->maKhoa) }}" class="btn btn-warning">Sửa</a>
                        <form id="deleteForm{{ $khoa->maKhoa }}" action="{{ route('khoa.destroy', $khoa->maKhoa) }}" method="POST" style="display:inline;">
                            @method('DELETE')
                            @csrf
                        </form>
                        <button data-form="deleteForm{{ $khoa->maKhoa }}" class="btn btn-delete btn-danger">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection --}}


@extends('layouts.app')
@section('page-title', "Khoa")
@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Danh Sách Khoa</h5>
        <a href="{{ route('khoa.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Khoa
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="khoaTable" width="100%">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Mã Khoa</th>
                        <th>Tên Khoa</th>
                        <th>Trưởng Khoa</th>
                        <th>Hành động</th> 
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
    $(document).ready(function(){
        $('#khoaTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('khoa.index') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'maKhoa', name: 'maKhoa' },
                { data: 'tenKhoa', name: 'tenKhoa' },
                { data: 'truong_khoa', name: 'truong_khoa' },
                { data: 'hanhdong', name: 'hanhdong', orderable: false, searchable: false }
            ]
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

