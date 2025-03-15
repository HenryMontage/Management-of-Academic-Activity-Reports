{{-- @extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <h1>Danh sách Bộ Môn</h1>
    <a href="{{ route('bomon.create') }}" class="btn btn-success">Thêm Bộ Môn</a>
    <table class="table table-hover" id="myTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã Bộ Môn</th>
                <th>Tên Bộ Môn</th>
                <th>Khoa</th>
                <th>Trưởng Bộ Môn</th>
                <th>Hành động</th>                                                  
            </tr>   
        </thead> 
        <tbody>
            @foreach($bomons as $bomon)
                <tr>
                    <td>{{ $loop->iteration }}</td>   
                    <td>{{ $bomon->maBoMon }}</td> 
                    <td>{{ $bomon->tenBoMon }}</td> 
                    <td>{{ $bomon->khoa->tenKhoa ?? 'Không có' }}</td>
                    <td>
                        {{ optional($bomon->truong_BoMon)->ho ? $bomon->truong_BoMon->ho . ' ' . $bomon->truong_BoMon->ten : 'Không' }}
                    </td>
                    
                    <td>
                        <a href="{{ route('bomon.edit', $bomon->maBoMon) }}" class="btn btn-warning">Sửa</a>
                        <form id="deleteForm{{ $bomon->maBoMon }}" action="{{ route('bomon.destroy', $bomon->maBoMon) }}" method="POST" style="display:inline;">
                            @method('DELETE')
                            @csrf
                        </form>
                        <button data-form="deleteForm{{ $bomon->maBoMon }}" class="btn btn-delete btn-danger">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}

@extends('layouts.app')
@section('page-title', "Bộ Môn")
@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Danh Sách Bộ Môn</h5>
        <a href="{{ route('bomon.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Bộ Môn
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="bomonTable" width="100%">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Mã Bộ Môn</th>
                        <th>Tên Bộ Môn</th>
                        <th>Khoa</th>
                        <th>Trưởng Bộ Môn</th>
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
    $(document).ready(function() {
        let table = $('#bomonTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('bomon.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'maBoMon', name: 'maBoMon' },
                { data: 'tenBoMon', name: 'tenBoMon' },
                { data: 'khoa', name: 'khoa' },
                { data: 'ho_ten_truong_bomon', name: 'ho_ten_truong_bomon' },
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


