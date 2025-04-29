@extends('layouts.app')

@section('page-title', "Thêm Nhân Viên")

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Thêm Nhân Viên</h2>

                    <form action="{{ route('nhanvien.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            {{-- Mã Nhân Viên & Ảnh đại diện --}}
                            <div class="col-md-6">
                                <label for="maNV" class="form-label">Mã Nhân Viên</label>
                                <input type="text" class="form-control @error('maNV') is-invalid @enderror" name="maNV" value="{{ old('maNV') }}">
                                @error('maNV')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="anhDaiDien" class="form-label">Ảnh đại diện</label>
                                <input type="file" class="form-control @error('anhDaiDien') is-invalid @enderror" name="anhDaiDien">
                                @error('anhDaiDien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Họ & Tên --}}
                            <div class="col-md-6">
                                <label for="ho" class="form-label">Họ</label>
                                <input type="text" class="form-control @error('ho') is-invalid @enderror" name="ho" value="{{ old('ho') }}">
                                @error('ho')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="ten" class="form-label">Tên</label>
                                <input type="text" class="form-control @error('ten') is-invalid @enderror" name="ten" value="{{ old('ten') }}">
                                @error('ten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email & SĐT --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="sdt" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control @error('sdt') is-invalid @enderror" name="sdt" value="{{ old('sdt') }}">
                                @error('sdt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Mật khẩu --}}
                            <div class="col-md-6">
                                <label for="matKhau" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control @error('matKhau') is-invalid @enderror" name="matKhau">
                                @error('matKhau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="matKhau_confirmation" class="form-label">Nhập lại Mật khẩu</label>
                                <input type="password" class="form-control @error('matKhau_confirmation') is-invalid @enderror" name="matKhau_confirmation">
                                @error('matKhau_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Nút --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('nhanvien.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                            <button type="submit" class="btn btn-primary btn-lg">Thêm Nhân Viên</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
