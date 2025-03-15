@extends('layouts.app')

@section('page-title', "Thêm Bộ Môn")

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Thêm Bộ Môn</h2>

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

                    <form action="{{ route('bomon.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            {{-- Mã Bộ Môn --}}
                            <div class="col-md-6">
                                <label for="maBoMon" class="form-label">Mã Bộ Môn</label>
                                <input type="text" class="form-control @error('maBoMon') is-invalid @enderror" id="maBoMon" name="maBoMon" value="{{ old('maBoMon') }}">
                                @error('maBoMon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Tên Bộ Môn --}}
                            <div class="col-md-6">
                                <label for="tenBoMon" class="form-label">Tên Bộ Môn</label>
                                <input type="text" class="form-control @error('tenBoMon') is-invalid @enderror" id="tenBoMon" name="tenBoMon" value="{{ old('tenBoMon') }}">
                                @error('tenBoMon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Khoa --}}
                            <div class="col-md-6">
                                <label for="maKhoa" class="form-label">Khoa</label>
                                <select name="maKhoa" id="maKhoa" class="form-control @error('maKhoa') is-invalid @enderror">
                                    <option value="">-- Chọn Khoa --</option>
                                    @foreach($khoas as $khoa)
                                        <option value="{{ $khoa->maKhoa }}" {{ old('maKhoa') == $khoa->maKhoa ? 'selected' : '' }}>
                                            {{ $khoa->tenKhoa }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('maKhoa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Trưởng Bộ Môn --}}
                            <div class="col-md-6">
                                <label for="truongBoMon" class="form-label">Trưởng Bộ Môn</label>
                                <select name="truongBoMon" class="form-control @error('truongBoMon') is-invalid @enderror">
                                    <option value="">-- Chọn Trưởng Bộ Môn --</option>
                                    @foreach ($giangviens as $giangvien)
                                        <option value="{{ $giangvien->maGiangVien }}" {{ old('truongBoMon') == $giangvien->maGiangVien ? 'selected' : '' }}>
                                            {{ $giangvien->ho }} {{ $giangvien->ten }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('truongBoMon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- Nút bấm --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('bomon.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                            <button type="submit" class="btn btn-primary btn-lg">Thêm Bộ Môn</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
