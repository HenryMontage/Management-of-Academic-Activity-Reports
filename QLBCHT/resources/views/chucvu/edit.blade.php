{{-- @extends('layouts.app')

@section('page-title', "Cập Nhật Chức Vụ")

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Cập Nhật Chức Vụ: {{ $chucvu->tenChucVu }}</h2>

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

                    <form action="{{ route('chucvu.update', $chucvu->maChucVu) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-section">
                            <div class="section-header">
                                <h5><i class="bi bi-pencil-square me-2"></i>Chỉnh Sửa Thông Tin</h5>
                            </div>
                            <div class="section-body row g-3">
                                <div class="col-md-6">
                                    <label for="maChucVu" class="form-label">Mã Chức Vụ</label>
                                    <input type="text" class="form-control" id="maChucVu" name="maChucVu" value="{{ old('maChucVu', $chucvu->maChucVu) }}" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label for="tenChucVu" class="form-label">Tên Chức Vụ</label>
                                    <input type="text" class="form-control @error('tenChucVu') is-invalid @enderror" id="tenChucVu" name="tenChucVu" value="{{ old('tenChucVu', $chucvu->tenChucVu) }}">
                                    @error('tenChucVu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="quyen_id" class="form-label">Quyền</label>
                                    <select name="quyen_id" id="quyen_id" class="form-control @error('quyen_id') is-invalid @enderror">
                                        <option value="">-- Chọn Quyền --</option>
                                        @foreach($quyens as $quyen)
                                            <option value="{{ $quyen->maQuyen }}" {{ $chucvu->quyen_id == $quyen->maQuyen ? 'selected' : '' }}>
                                                {{ $quyen->tenQuyen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('quyen_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('chucvu.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                            <button type="submit" class="btn btn-success btn-lg">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}




@extends('layouts.app')

@section('page-title', "Cập Nhật Chức Vụ")

@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header">
            <h4 class="mb-0"><i class="fas fa-university me-2"></i>Cập Nhật Chức Vụ {{ $chucvu->tenChucVu }}</h4>
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

            <form action="{{ route('chucvu.update', $chucvu->maChucVu) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Thông tin khoa -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin chức vụ</h5>
                    </div>
                    <div class="section-body row">
                        <div class="col-md-6">
                            <label for="maChucVu" class="form-label">Mã chức vụ</label>
                            <input type="text" class="form-control" id="maChucVu" name="maChucVu" value="{{ old('maChucVu', $chucvu->maChucVu) }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="tenChucVu" class="form-label">Tên Chức Vụ</label>
                            <input type="text" class="form-control @error('tenChucVu') is-invalid @enderror" id="tenChucVu" name="tenChucVu" value="{{ old('tenChucVu', $chucvu->tenChucVu) }}">
                            @error('tenChucVu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Quyền</h5>
                    </div>
                    <div class="section-body row">
                        <div class="col-md-12">
                            <label for="quyen_id" class="form-label">Chọn Quyền</label>
                            <select name="quyen_id" id="quyen_id" class="form-control @error('quyen_id') is-invalid @enderror">
                                <option value="">-- Chọn Quyền --</option>
                                @foreach($quyens as $quyen)
                                    <option value="{{ $quyen->maQuyen }}" {{ $chucvu->quyen_id == $quyen->maQuyen ? 'selected' : '' }}>
                                        {{ $quyen->tenQuyen }}
                                    </option>
                                @endforeach
                            </select>
                            @error('quyen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="{{ route('chucvu.index') }}" class="btn btn-secondary btn-fixed">
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

