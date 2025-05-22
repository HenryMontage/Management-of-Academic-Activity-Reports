@extends('layouts.app')

@section('page-title', "Thêm Bộ Môn")

@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header">
            <h4 class="mb-0"><i class="fas fa-layer-group me-2"></i>Thêm Bộ Môn</h4>
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

            <form action="{{ route('bomon.store') }}" method="POST">
                @csrf

                <!-- Thông tin bộ môn -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin bộ môn</h5>
                    </div>
                    <div class="section-body row">
                        <div class="col-md-6">
                            <label for="maBoMon" class="form-label">Mã Bộ Môn</label>
                            <input type="text" class="form-control @error('maBoMon') is-invalid @enderror" name="maBoMon" value="{{ old('maBoMon') }}">
                            @error('maBoMon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tenBoMon" class="form-label">Tên Bộ Môn</label>
                            <input type="text" class="form-control @error('tenBoMon') is-invalid @enderror" name="tenBoMon" value="{{ old('tenBoMon') }}">
                            @error('tenBoMon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Khoa và trưởng bộ môn -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-users-cog me-2"></i>Quản lý</h5>
                    </div>
                    <div class="section-body row">
                        <div class="col-md-6">
                            <label for="maKhoa" class="form-label">Khoa</label>
                            <select name="maKhoa" class="form-select @error('maKhoa') is-invalid @enderror">
                                <option value="">-- Chọn Khoa --</option>
                                @foreach ($khoas as $khoa)
                                    <option value="{{ $khoa->maKhoa }}" {{ old('maKhoa') == $khoa->maKhoa ? 'selected' : '' }}>
                                        {{ $khoa->tenKhoa }}
                                    </option>
                                @endforeach
                            </select>
                            @error('maKhoa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="truongBoMon" class="form-label">Trưởng Bộ Môn</label>
                            <select name="truongBoMon" class="form-select @error('truongBoMon') is-invalid @enderror">
                                <option value="">-- Chọn Trưởng Bộ Môn --</option>
                                @foreach ($giangviens as $gv)
                                    <option value="{{ $gv->maGiangVien }}" {{ old('truongBoMon') == $gv->maGiangVien ? 'selected' : '' }}>
                                        {{ $gv->ho }} {{ $gv->ten }}
                                    </option>
                                @endforeach
                            </select>
                            @error('truongBoMon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Nút -->
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="{{ route('bomon.index') }}" class="btn btn-secondary btn-fixed">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-success btn-fixed">
                        <i class="fas fa-plus me-2"></i>Thêm Bộ Môn
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
