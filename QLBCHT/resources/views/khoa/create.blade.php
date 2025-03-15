@extends('layouts.app')

@section('page-title', "Thêm Khoa")

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Thêm Khoa</h2>

                    {{-- Hiển thị lỗi nếu có --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('khoa.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            {{-- Mã Khoa --}}
                            <div class="col-md-6">
                                <label for="maKhoa" class="form-label">Mã Khoa</label>
                                <input type="text" class="form-control @error('maKhoa') is-invalid @enderror" id="maKhoa" name="maKhoa" value="{{ old('maKhoa') }}">
                                @error('maKhoa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Tên Khoa --}}
                            <div class="col-md-6">
                                <label for="tenKhoa" class="form-label">Tên Khoa</label>
                                <input type="text" class="form-control @error('tenKhoa') is-invalid @enderror" id="tenKhoa" name="tenKhoa" value="{{ old('tenKhoa') }}">
                                @error('tenKhoa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Trưởng Khoa --}}
                            <div class="col-md-12">
                                <label for="truongKhoa" class="form-label">Trưởng Khoa</label>
                                <select name="truongKhoa" id="truongKhoa" class="form-control @error('truongKhoa') is-invalid @enderror">
                                    <option value="">-- Chọn Trưởng Khoa --</option>
                                    @foreach ($giangviens as $giangvien)
                                        <option value="{{ $giangvien->maGiangVien }}" {{ old('truongKhoa') == $giangvien->maGiangVien ? 'selected' : '' }}>
                                            {{ $giangvien->ho }} {{ $giangvien->ten }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('truongKhoa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- Nút bấm --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('khoa.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                            <button type="submit" class="btn btn-primary btn-lg">Thêm Khoa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
