{{-- @extends('layouts.user')
@section('content')
<div class="container">
    <h3>Danh sách báo cáo đã nộp</h3>
    <a href="{{ route('baocao.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nộp báo cáo
    </a>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($baoCaos->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên báo cáo</th>
                    <th>Ngày nộp</th>
                    <th>Định dạng</th>
                    <th>Tóm tắt</th>
                    <th>File</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($baoCaos as $baoCao)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $baoCao->tenBaoCao }}</td>
                    <td>{{ $baoCao->ngayNop }}</td>
                    <td>{{ $baoCao->dinhDang }}</td>
                    <td>{{ $baoCao->tomTat }}</td>
                    <td>
                        <a href="{{ url($baoCao->duongDanFile) }}" target="_blank">Tải file</a>
                    </td>
                    <td>
                        <form action="{{ route('baocao.destroy', $baoCao->maBaoCao) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa báo cáo này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Chưa có báo cáo nào được nộp.</p>
    @endif
</div>
@endsection --}}

@extends('layouts.user')
@section('page-title', "Danh Sách Báo Cáo")
@section('content')
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Danh Sách Báo Cáo Đã Nộp</h5>
        <a href="{{ route('baocao.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nộp Báo Cáo
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="baoCaoTable" width="100%">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Tên Báo Cáo</th>
                        <th>Ngày Nộp</th>
                        <th>Định Dạng</th>
                        <th>Tóm Tắt</th>
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
        $('#baoCaoTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("baocao.index") }}', // Đảm bảo đúng URL
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'tenBaoCao', name: 'tenBaoCao' },
        { data: 'ngayNop', name: 'ngayNop' },
        { data: 'dinhDang', name: 'dinhDang' },
        { data: 'tomTat', name: 'tomTat' },
        // { data: 'file', name: 'file'},
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
