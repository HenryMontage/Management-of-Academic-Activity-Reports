@extends('layouts.app')

@section('page-title', "Thêm Quản Trị Viên")

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Thêm Quản Trị Viên</h2>

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

                    <form action="{{ route('admin.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            {{-- Họ --}}
                            <div class="col-md-6">
                                <label for="ho" class="form-label">Họ</label>
                                <input type="text" class="form-control @error('ho') is-invalid @enderror" id="ho" name="ho" value="{{ old('ho') }}">
                                @error('ho')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            {{-- Tên --}}
                            <div class="col-md-6">
                                <label for="ten" class="form-label">Tên</label>
                                <input type="text" class="form-control @error('ten') is-invalid @enderror" id="ten" name="ten" value="{{ old('ten') }}">
                                @error('ten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            {{-- Số điện thoại --}}
                            <div class="col-md-6">
                                <label for="sdt" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control @error('sdt') is-invalid @enderror" id="sdt" name="sdt" value="{{ old('sdt') }}">
                                @error('sdt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            {{-- Mật khẩu --}}
                            <div class="col-md-6">
                                <label for="matKhau" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control @error('matKhau') is-invalid @enderror" id="matKhau" name="matKhau">
                                @error('matKhau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            {{-- Nhập lại mật khẩu --}}
                            <div class="col-md-6">
                                <label for="matKhau_confirmation" class="form-label">Nhập lại Mật khẩu</label>
                                <input type="password" class="form-control @error('matKhau_confirmation') is-invalid @enderror" id="matKhau_confirmation" name="matKhau_confirmation">
                                @error('matKhau_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    
                        {{-- Nút bấm --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                            <button type="submit" class="btn btn-primary btn-lg">Thêm Quản Trị Viên</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
