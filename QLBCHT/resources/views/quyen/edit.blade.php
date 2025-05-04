@php
    $routeLabels = [
        'admin' => 'Quản trị viên',
        'nhanvien' => 'Nhân viên PĐBCL',
        'giangvien' => 'Giảng viên',
        'khoa' => 'Khoa',
        'bomon' => 'Bộ môn',
        'chucvu' => 'Chức vụ',
        'quyen' => 'Quyền',
        'lichbaocao' => 'Lịch báo cáo',
        'dangkybaocao' => 'Đăng ký báo cáo',
        'baocao' => 'Báo cáo',
        'bienban' => 'Biên bản',
        'duyet' => 'Xác nhận phiếu đăng ký',
        'xacnhan' => 'Xác nhận biên bản',
    ];
@endphp

@extends('layouts.app')
@section('content')
<form action="{{ route('quyen.update', $quyen->maQuyen) }}" method="POST" class="p-4 border rounded bg-white shadow">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Tên quyền:</label>
        <input type="text" name="tenQuyen" class="form-control" value="{{ $quyen->tenQuyen }}" required>
    </div>

    <div class="mb-3">
        <p><strong>Nhóm chức năng được phép truy cập:</strong></p>
        @foreach ($routeLabels as $route => $label)
            <div class="form-check">
                <input class="form-check-input"
                       type="checkbox"
                       name="nhomRoute[]"
                       value="{{ $route }}"
                       id="{{ $route }}"
                       {{ is_array($quyen->nhomRoute) && in_array($route, $quyen->nhomRoute) ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $route }}">
                    {{ $label }}
                </label>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
@endsection
