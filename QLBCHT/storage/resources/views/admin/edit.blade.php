@extends('layouts.app')

@section('page-title', "Cập Nhật Quản Trị Viên")

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Cập Nhật Quản Trị Viên {{ $admin->ho }} {{ $admin->ten }}</h2>

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

                    <form action="{{ route('admin.update', $admin->maAdmin) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            {{-- Mã Admin (readonly) --}}
                            <div class="col-md-6">
                                <label for="maAdmin" class="form-label">Mã Admin</label>
                                <input type="text" class="form-control" id="maAdmin" name="maAdmin" value="{{ old('maAdmin', $admin->maAdmin) }}" readonly>
                            </div>

                             {{-- Quyền --}}
                             <div class="col-md-6">
                                <label for="quyen_id" class="form-label">Quyền</label>
                                <select name="quyen_id" id="quyen_id" class="form-control @error('quyen_id') is-invalid @enderror">
                                    <option value="">-- Chọn Quyền --</option>
                                    {{-- @foreach ($quyens as $quyen)
                                        <option value="{{ $quyen->maQuyen }}" {{ old('quyen_id', $admin->quyen_id) == $quyen->maQuyen ? 'selected' : '' }}>
                                            {{ $quyen->tenQuyen }}
                                        </option>
                                    @endforeach --}}
                                    @forelse($quyens as $quyen)
                                        <option value="{{ $quyen->maQuyen }}">{{ $quyen->tenQuyen }}</option>
                                    @empty
                                        <option disabled>⚠️ Chưa có quyền nào trong hệ thống</option>
                                    @endforelse
                                </select>
                                @error('quyen_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Họ và Tên --}}
                            <div class="col-md-6">
                                <label for="ho" class="form-label">Họ</label>
                                <input type="text" class="form-control @error('ho') is-invalid @enderror" id="ho" name="ho" value="{{ old('ho', $admin->ho) }}">
                                @error('ho')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="ten" class="form-label">Tên</label>
                                <input type="text" class="form-control @error('ten') is-invalid @enderror" id="ten" name="ten" value="{{ old('ten', $admin->ten) }}">
                                @error('ten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email và SĐT --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $admin->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="sdt" class="form-label">Số Điện Thoại</label>
                                <input type="text" class="form-control @error('sdt') is-invalid @enderror" id="sdt" name="sdt" value="{{ old('sdt', $admin->sdt) }}">
                                @error('sdt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Mật khẩu --}}
                            <div class="col-md-6">
                                <label for="matKhau" class="form-label">Mật Khẩu (Không nhập nếu không đổi)</label>
                                <input type="password" class="form-control @error('matKhau') is-invalid @enderror" id="matKhau" name="matKhau">
                                @error('matKhau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                            <button type="submit" class="btn btn-primary btn-lg">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
