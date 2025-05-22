@extends('layouts.app')

@section('page-title', "Cập Nhật PĐBCL")

@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header">
            <h4 class="mb-0"><i class="fas fa-user-shield me-2"></i>Cập Nhật Nhân Viên PĐBCL</h4>
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

            <form action="{{ route('nhanvien.update', $nhanvien->maNV) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Thông tin nhân viên -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-id-badge me-2"></i>Thông tin nhân viên</h5>
                    </div>
                    <div class="section-body row">
                        <div class="text-center mb-4">
                            <label class="form-label d-block">Ảnh đại diện hiện tại</label>
                            <img src="{{ asset('storage/' . ($nhanvien->anhDaiDien ?? 'anhDaiDiens/anhmacdinh.jpg')) }}"
                                 alt="Ảnh đại diện"
                                 class="img-fluid rounded-circle shadow-sm"
                                 style="width: 140px; height: 140px; object-fit: cover;"
                                 onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($nhanvien->ho . ' ' . $nhanvien->ten) }}&background=0D8ABC&color=fff';">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mã Nhân Viên</label>
                            <input type="text" class="form-control" value="{{ $nhanvien->maNV }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="anhDaiDien" class="form-label">Cập nhật ảnh đại diện</label>
                            <input type="file" class="form-control @error('anhDaiDien') is-invalid @enderror" name="anhDaiDien" id="anhDaiDien">
                            @error('anhDaiDien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="ho" class="form-label">Họ</label>
                            <input type="text" class="form-control @error('ho') is-invalid @enderror" name="ho" id="ho" value="{{ old('ho', $nhanvien->ho) }}">
                            @error('ho')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="ten" class="form-label">Tên</label>
                            <input type="text" class="form-control @error('ten') is-invalid @enderror" name="ten" id="ten" value="{{ old('ten', $nhanvien->ten) }}">
                            @error('ten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Thông tin liên hệ -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-envelope me-2"></i>Thông tin liên hệ</h5>
                    </div>
                    <div class="section-body row">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', $nhanvien->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="sdt" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control @error('sdt') is-invalid @enderror" name="sdt" id="sdt" value="{{ old('sdt', $nhanvien->sdt) }}">
                            @error('sdt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Mật khẩu -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Mật khẩu</h5>
                    </div>
                    <div class="section-body row">
                        <div class="col-md-6">
                            <label for="matKhau" class="form-label">Mật khẩu mới (nếu muốn đổi)</label>
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

                <!-- Phân quyền -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-user-tag me-2"></i>Phân quyền</h5>
                    </div>
                    <div class="section-body row">
                        <div class="col-md-12">
                            <label for="quyen_id" class="form-label">Quyền</label>
                            <select class="form-select @error('quyen_id') is-invalid @enderror" name="quyen_id" id="quyen_id">
                                <option value="">-- Chọn quyền --</option>
                                @forelse($quyens as $quyen)
                                    <option value="{{ $quyen->maQuyen }}" {{ $quyen->maQuyen == old('quyen_id', $nhanvien->quyen_id) ? 'selected' : '' }}>
                                        {{ $quyen->tenQuyen }}
                                    </option>
                                @empty
                                    <option disabled>⚠️ Chưa có quyền nào</option>
                                @endforelse
                            </select>
                            @error('quyen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Nút thao tác -->
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="{{ route('nhanvien.index') }}" class="btn btn-secondary btn-fixed">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-success btn-fixed">
                        <i class="fas fa-save me-2"></i>Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
