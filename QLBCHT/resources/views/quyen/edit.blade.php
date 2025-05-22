@php
    $routeLabels = [
        'admin' => 'Quản trị viên',
        'nhanvien' => 'PĐBCL',
        'giangvien' => 'Giảng viên',
        'khoa' => 'Khoa',
        'bomon' => 'Bộ môn',
        'chucvu' => 'Chức vụ',
        'quyen' => 'Quyền',
        'email' => 'Email',
        'lichbaocao' => 'Lịch báo cáo',
        'dangkybaocao' => 'Đăng ký báo cáo',
        'baocao' => 'Báo cáo',
        'lichbaocaodangky' => 'Đăng ký SHHT',
        'bienban' => 'Biên bản',
        'duyet' => 'Xác nhận phiếu đăng ký',
        'xacnhan' => 'Xác nhận biên bản',
    ];
@endphp



<style>
    .custom-checkbox-container {
        position: relative;
        cursor: pointer;
        display: block;
        user-select: none;
    }

    .custom-checkbox-container input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .custom-box {
        border: 2px solid #ccc;
        border-radius: 5px;
        padding: 12px;
        text-align: center;
        transition: border-color 0.3s, background-color 0.3s;
        font-weight: 500;
    }

    .custom-checkbox-container input[type="checkbox"]:checked ~ .custom-box {
        border-color: #0d6efd;
        background-color: #e7f1ff;
    }

    .custom-box:hover {
        background-color: #f8f9fa;
    }
</style>

@extends('layouts.app')
@section('page-title', "Cập Nhật Quyền")
@section('content')
<form action="{{ route('quyen.update', $quyen->maQuyen) }}" method="POST" class="p-4 border rounded bg-white shadow">
    @csrf
    @method('PUT')

    {{-- <div class="mb-3">
        <label class="form-label fs-5 fw-bold">Tên quyền:</label>
        <input type="text" name="tenQuyen" class="form-control" value="{{ $quyen->tenQuyen }}" required>
    </div> --}}

    <div class="form-section">
        <div class="section-header">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin quyền</h5>
        </div>
        <div class="section-body row">
            <div class="mb-3">
                <label class="form-label fs-5">Tên quyền</label>
                <input type="text" name="tenQuyen" class="form-control" value="{{ $quyen->tenQuyen }}" required>
            </div>
        </div>
    </div>

    <div class="form-section">
        <div class="section-header">
            <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Nhóm chức năng được phép truy cập</h5>
        </div>
        <div class="section-body row">
            <div class="mb-3 border rounded p-3">
                {{-- <p class="fw-bold mb-2">Nhóm chức năng được phép truy cập:</p> --}}
        
                {{-- Nút chọn tất cả --}}
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                        <label class="form-check-label fw-bold" for="selectAll">Chọn tất cả / Bỏ chọn tất cả</label>
                    </div>
                </div>
        
        
                {{-- Các checkbox hiển thị 3 cột, click vào thẻ sẽ chọn --}}
                <div class="row">
                    @foreach ($routeLabels as $route => $label)
                        <div class="col-md-4 mb-2">
                            <label class="custom-checkbox-container w-100">
                                <input type="checkbox" name="nhomRoute[]" value="{{ $route }}" id="{{ $route }}"
                                    {{ is_array($quyen->nhomRoute) && in_array($route, $quyen->nhomRoute) ? 'checked' : '' }}>
                                <div class="custom-box">
                                    {{ $label }}
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-3">
        <a href="{{ route('quyen.index') }}" class="btn btn-secondary" style="min-width: 100px">Quay lại</a>
        <button type="submit" class="btn btn-success" style="min-width: 100px">Cập nhật</button>
    </div>
</form>

{{-- Script chọn tất cả --}}
<script>
    document.getElementById('selectAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="nhomRoute[]"]');
        checkboxes.forEach(cb => {
            cb.checked = this.checked;
            cb.dispatchEvent(new Event('change'));
        });
    });
</script>
@endsection
