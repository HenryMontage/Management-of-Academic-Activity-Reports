@extends('layouts.app')

@section('page-title', "Cập Nhật Khoa")

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Cập Nhật Khoa {{ $khoa->tenKhoa }}</h2>

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

                    <form action="{{ route('khoa.update', $khoa->maKhoa) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            {{-- Mã Khoa (readonly) --}}
                            <div class="col-md-6">
                                <label for="maKhoa" class="form-label">Mã Khoa</label>
                                <input type="text" class="form-control" id="maKhoa" name="maKhoa" value="{{ old('maKhoa', $khoa->maKhoa) }}" readonly>
                            </div>
                            
                            {{-- Tên Khoa --}}
                            <div class="col-md-6">
                                <label for="tenKhoa" class="form-label">Tên Khoa</label>
                                <input type="text" class="form-control @error('tenKhoa') is-invalid @enderror" id="tenKhoa" name="tenKhoa" value="{{ old('tenKhoa', $khoa->tenKhoa) }}">
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
                                        <option value="{{ $giangvien->maGiangVien }}" {{ old('truongKhoa', $khoa->truongKhoa) == $giangvien->maGiangVien ? 'selected' : '' }}>
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
                            <button type="submit" class="btn btn-primary btn-lg">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
