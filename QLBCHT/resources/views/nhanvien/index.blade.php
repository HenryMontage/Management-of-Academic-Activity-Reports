@extends('layouts.app')

@section('page-title', 'Danh sách Nhân Viên')

@section('content')
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Danh sách Nhân Viên</h2>
        <a href="{{ route('nhanvien.create') }}" class="btn btn-primary">+ Thêm Nhân Viên</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Ảnh</th>
                    <th>Mã NV</th>
                    <th>Họ Tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nhanviens as $nv)
                    <tr>
                        <td>
                            {{-- <img src="{{ asset('storage/' . $nv->anhDaiDien) }}" width="50" height="50" class="rounded-circle" alt="Ảnh"> --}}
                            <img src="{{ asset('storage/' . ($nv->anhDaiDien ?? 'anhDaiDiens/anhmacdinh.jpg')) }}" 
                                         alt="Ảnh đại diện" 
                                         class="img-fluid rounded-circle mb-3 shadow" 
                                         style="width: 50px; height: 50px; object-fit: cover;"
                                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{  urlencode($nv->ho . ' ' . $nv->ten) }}&background=0D8ABC&color=fff';">
                        </td>
                        
                        <td>{{ $nv->maNV }}</td>
                        <td>{{ $nv->ho }} {{ $nv->ten }}</td>
                        <td>{{ $nv->email }}</td>
                        <td>{{ $nv->sdt }}</td>
                        <td>
                            <a href="{{ route('nhanvien.edit', $nv->maNV) }}" class="btn btn-sm btn-warning">Sửa</a>

                            <form action="{{ route('nhanvien.destroy', $nv->maNV) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Không có nhân viên nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
