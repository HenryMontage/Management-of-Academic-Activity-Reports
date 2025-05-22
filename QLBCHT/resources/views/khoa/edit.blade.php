@extends('layouts.app')

@section('page-title', "Cập Nhật Khoa")

@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header">
            <h4 class="mb-0"><i class="fas fa-university me-2"></i>Cập Nhật Khoa {{ $khoa->tenKhoa }}</h4>
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

            <form action="{{ route('khoa.update', $khoa->maKhoa) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Thông tin khoa -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin khoa</h5>
                    </div>
                    <div class="section-body row">
                        <div class="col-md-6">
                            <label for="maKhoa" class="form-label">Mã Khoa</label>
                            <input type="text" class="form-control" id="maKhoa" name="maKhoa" value="{{ old('maKhoa', $khoa->maKhoa) }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="tenKhoa" class="form-label">Tên Khoa</label>
                            <input type="text" class="form-control @error('tenKhoa') is-invalid @enderror" id="tenKhoa" name="tenKhoa" value="{{ old('tenKhoa', $khoa->tenKhoa) }}">
                            @error('tenKhoa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Trưởng khoa -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i>Trưởng khoa</h5>
                    </div>
                    <div class="section-body row">
                        <div class="col-md-12">
                            <label for="truongKhoa" class="form-label">Chọn Trưởng Khoa</label>
                            <select name="truongKhoa" id="truongKhoa" class="form-select @error('truongKhoa') is-invalid @enderror">
                                <option value="">-- Chọn Trưởng Khoa --</option>
                                @foreach ($giangviens as $gv)
                                    <option value="{{ $gv->maGiangVien }}" {{ old('truongKhoa', $khoa->truongKhoa) == $gv->maGiangVien ? 'selected' : '' }}>
                                        {{ $gv->ho }} {{ $gv->ten }}
                                    </option>
                                @endforeach
                            </select>
                            @error('truongKhoa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="{{ route('khoa.index') }}" class="btn btn-secondary btn-fixed">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-success btn-fixed">
                        <i class="fas fa-save me-2"></i>Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
