@extends('layouts.app')
@section('page-title', "Cài đặt Email")

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Cập Nhật Cấu Hình Email</h2>

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

                    {{-- Hiển thị thông báo thành công --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('email-settings.save') }}">
                        @csrf
                        {{-- @method('PUT') --}}
                        {{-- <input type="hidden" name="id" value="{{ $setting->id }}"> --}}

                        <div class="row g-3">
                            {{-- Email gửi đi --}}
                            <div class="col-md-12">
                                <label for="username" class="form-label">Email gửi đi</label>
                                <input type="email" id="username" name="username" 
                                    class="form-control @error('username') is-invalid @enderror" 
                                    value="{{ old('username', $setting->username ?? '') }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Mật khẩu --}}
                            <div class="col-md-12">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" id="password" name="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    value="{{ old('password', $setting->password ?? '') }}" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email người gửi --}}
                            <div class="col-md-12">
                                <label for="from_address" class="form-label">Email người gửi</label>
                                <input type="email" id="from_address" name="from_address" 
                                    class="form-control @error('from_address') is-invalid @enderror" 
                                    value="{{ old('from_address', $setting->from_address ?? '') }}" required>
                                @error('from_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tên người gửi --}}
                            <div class="col-md-12">
                                <label for="from_name" class="form-label">Tên người gửi</label>
                                <input type="text" id="from_name" name="from_name" 
                                    class="form-control @error('from_name') is-invalid @enderror" 
                                    value="{{ old('from_name', $setting->from_name ?? '') }}" required>
                                @error('from_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Nút lưu --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('email-settings.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                            <button type="submit" class="btn btn-success btn-lg">Lưu Cấu Hình</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
