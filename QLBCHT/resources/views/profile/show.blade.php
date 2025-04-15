@extends('layouts.user')

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Ảnh đại diện -->
                            <div class="col-md-4 text-center mb-4">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . ($user->anhDaiDien ?? 'anhDaiDiens/anhmacdinh.jpg')) }}" 
                                         alt="Ảnh đại diện" 
                                         class="img-fluid rounded-circle mb-3 shadow" 
                                         style="width: 200px; height: 200px; object-fit: cover;"
                                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{  urlencode($user->ho . ' ' . $user->ten) }}&background=0D8ABC&color=fff';">
                                    <div class="custom-file mt-2">
                                        <input type="file" class="form-control" name="anhDaiDien">
                                        <label class="form-label text-muted mt-2">Thay đổi ảnh đại diện</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Thông tin cá nhân -->
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="ho" class="form-label">Họ</label>
                                        <input type="text" class="form-control" name="ho" value="{{ old('ho', $user->ho) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="ten" class="form-label">Tên</label>
                                        <input type="text" class="form-control" name="ten" value="{{ old('ten', $user->ten) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sdt" class="form-label">Số điện thoại</label>
                                        <input type="text" class="form-control" name="sdt" value="{{ old('sdt', $user->sdt) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                    </div>

                                    @if ($guard === 'giang_viens')
                                        <div class="col-md-6">
                                            <label for="chucVu" class="form-label">Chức vụ</label>
                                            <input type="text" class="form-control" value="{{ \App\Models\ChucVu::find($user->chucVu)?->tenChucVu ?? 'Không rõ' }}" disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="boMon_id" class="form-label">Bộ môn</label>
                                            <input type="text" class="form-control" value="{{ $user->boMon->tenBoMon ?? $user->boMon_id }}" disabled>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Đổi mật khẩu -->
                        <hr class="my-4">
                        <h4 class="mb-3">Đổi mật khẩu</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="matKhau" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" name="matKhau" placeholder="Nhập mật khẩu mới">
                            </div>

                            <div class="col-md-6">
                                <label for="matKhau_confirmation" class="form-label">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" name="matKhau_confirmation">
                            </div>
                        </div>

                        <!-- Nút submit -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
