@extends('layouts.app')

@section('page-title', "Thêm Khoa")

@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header">
            <h4 class="mb-0"><i class="fas fa-university me-2"></i>Thêm Khoa</h4>
        </div>
        <div class="form-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('khoa.store') }}" method="POST">
                @csrf
                <!-- Thông tin khoa -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin khoa</h5>
                    </div>
                    <div class="section-body row">
                        <div class="col-md-6">
                            <label for="maKhoa" class="form-label">Mã Khoa</label>
                            <input type="text" class="form-control @error('maKhoa') is-invalid @enderror" id="maKhoa" name="maKhoa" value="{{ old('maKhoa') }}">
                            @error('maKhoa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tenKhoa" class="form-label">Tên Khoa</label>
                            <input type="text" class="form-control @error('tenKhoa') is-invalid @enderror" id="tenKhoa" name="tenKhoa" value="{{ old('tenKhoa') }}">
                            @error('tenKhoa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="truongKhoa" class="form-label">Trưởng Khoa</label>
                            <select name="truongKhoa" id="truongKhoa" class="form-select @error('truongKhoa') is-invalid @enderror">
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
                </div>

                <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="{{ route('khoa.index') }}" class="btn btn-secondary btn-fixed">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-success btn-fixed">
                        <i class="fas fa-plus me-2"></i>Thêm Khoa
                    </button>
                </div>
               
            </form>
        </div>
    </div>
</div>
@endsection
