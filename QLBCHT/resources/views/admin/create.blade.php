@extends('layouts.app')

@section('content')
<style>
   
</style>

<div class="fixed-container">
    <div class="form-container">
        <div class="form-header">
            <h4 class="mb-0"><i class="fas fa-user-shield me-2"></i>Thêm Quản Trị Viên</h4>
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

            <form action="{{ route('admin.store') }}" method="POST">
                @csrf

                <!-- Thông tin chung -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin quản trị viên</h5>
                    </div>
                    <div class="section-body row">
                        <div class="col-md-6">
                            <label for="maAdmin" class="form-label">Mã quản trị viên</label>
                            <input type="text" class="form-control @error('maAdmin') is-invalid @enderror" name="maAdmin" id="maAdmin" value="{{ old('maAdmin') }}">
                            @error('maAdmin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="quyen_id" class="form-label">Quyền</label>
                            <select name="quyen_id" id="quyen_id" class="form-select @error('quyen_id') is-invalid @enderror">
                                <option value="">-- Chọn quyền --</option>
                                @foreach($quyens as $quyen)
                                    <option value="{{ $quyen->maQuyen }}" {{ old('quyen_id') == $quyen->maQuyen ? 'selected' : '' }}>
                                        {{ $quyen->tenQuyen }}
                                    </option>
                                @endforeach
                            </select>
                            @error('quyen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="ho" class="form-label">Họ</label>
                            <input type="text" class="form-control @error('ho') is-invalid @enderror" name="ho" id="ho" value="{{ old('ho') }}">
                            @error('ho')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="ten" class="form-label">Tên</label>
                            <input type="text" class="form-control @error('ten') is-invalid @enderror" name="ten" id="ten" value="{{ old('ten') }}">
                            @error('ten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Liên hệ -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-phone-alt me-2"></i>Thông tin liên hệ</h5>
                    </div>
                    <div class="section-body row">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="sdt" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control @error('sdt') is-invalid @enderror" name="sdt" id="sdt" value="{{ old('sdt') }}">
                            @error('sdt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Mật khẩu -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-key me-2"></i>Mật khẩu</h5>
                    </div>
                    <div class="section-body row">
                        <div class="col-md-6">
                            <label for="matKhau" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control @error('matKhau') is-invalid @enderror" name="matKhau" id="matKhau">
                            @error('matKhau')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="matKhau_confirmation" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control @error('matKhau_confirmation') is-invalid @enderror" name="matKhau_confirmation" id="matKhau_confirmation">
                            @error('matKhau_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary btn-fixed">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-success btn-fixed">
                        <i class="fas fa-user-plus me-2"></i>Thêm mới
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
