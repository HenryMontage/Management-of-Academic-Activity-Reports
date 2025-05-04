@php
    $routeLabels = [
        'admin' => 'Quản trị viên',
        'nhanvien' => 'Nhân viên PĐBCL',
        'giangvien' => 'Giảng viên',
        'khoa' => 'Khoa',
        'bomon' => 'Bộ môn',
        'chucvu' => 'Chức vụ',
        'quyen' => 'Quyền',
        'email' => 'Email',
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
<form action="{{ route('quyen.store') }}" method="POST" class="p-4 border rounded bg-white shadow">
    @csrf
    <div class="mb-3">
        <label class="form-label">Tên quyền:</label>
        <input type="text" name="tenQuyen" class="form-control" required>
    </div>

    {{-- <div class="mb-3">
        <p><strong>Nhóm chức năng được phép truy cập:</strong></p>
        @foreach (['admin', 'nhanvien', 'giangvien', 'khoa', 'bomon', 'chucvu', 'quyen', 'lichbaocao','dangkybaocao','baocao','bienban','xacnhanphieu','xacnhanbienban'] as $route)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="nhomRoute[]" value="{{ $route }}" id="{{ $route }}">
                <label class="form-check-label" for="{{ $route }}">
                    {{ ucfirst($route) }}
                </label>
            </div>
        @endforeach
    </div> --}}
    <div class="mb-3">
        <p><strong>Nhóm chức năng được phép truy cập:</strong></p>
        @foreach ($routeLabels as $route => $label)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="nhomRoute[]" value="{{ $route }}" id="{{ $route }}">
                <label class="form-check-label" for="{{ $route }}">
                    {{ $label }}
                </label>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-primary">Lưu</button>
</form>


@endsection