@extends('layouts.user')

{{-- @section('content')
<div class="container py-3">
    <h1 class="mb-4 text-center">Danh Sách Lịch Báo Cáo</h1>
    
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('lichbaocao.create') }}" class="btn btn-primary">Tạo Lịch Báo Cáo Mới</a>
    </div>

    @if($lichBaoCaos->isEmpty())
        <div class="alert alert-warning text-center">Chưa có lịch báo cáo nào.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Chủ Đề</th>
                        <th>Ngày Báo Cáo</th>
                        <th>Giờ Báo Cáo</th>
                        <th>Hạn Ngày Nộp</th>
                        <th>Hạn Giờ Nộp</th>
                        <th>Bộ Môn</th>
                        <th>Giảng Viên Phụ Trách</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lichBaoCaos as $index => $lich)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $lich->chuDe }}</td>
                            <td>{{ $lich->ngayBaoCao }}</td>
                            <td>{{ $lich->gioBaoCao }}</td>
                            <td>{{ $lich->hanNgayNop }}</td>
                            <td>{{ $lich->hanGioNop }}</td>
                            <td>{{ $lich->boMon->tenBoMon ?? 'N/A' }}</td>
                            <td>
                                @if ($lich->giangVienPhuTrach)
                                    <ul>
                                        @foreach ($lich->giangVienPhuTrach as $gv)
                                            <li>{{ $gv->ho }} {{ $gv->ten }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    Chưa phân công
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('lichbaocao.edit', $lich->maLich) }}" class="btn btn-sm btn-warning">Sửa</a>
                                <form action="{{ route('lichbaocao.destroy', $lich->maLich) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection --}}

@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Danh Sách Lịch Sinh Hoạt Học Thuật</h5>
        @php 
            $guard = session('current_guard');
            $user = Auth::guard($guard)->user();
        @endphp
        @if($user->chucVu != 1)
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
@endsection

@section('script')
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
</script>
@endsection
