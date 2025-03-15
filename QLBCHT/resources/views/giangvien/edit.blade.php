@extends('layouts.app')

@section('page-title', "Cập Nhật Giảng Viên")

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Cập Nhật Giảng Viên {{ $giangvien->ho }} {{ $giangvien->ten }}</h2>

                    <form action="{{ route('giangvien.update', $giangvien) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            {{-- Ảnh Đại Diện --}}
                            <div class="text-center">
                                <label class="form-label">Ảnh Đại Diện Hiện Tại</label><br>
                                <img src="{{ asset('storage/'.$giangvien->anhDaiDien ?? 'anhDaiDiens/anhmacdinh.jpg') }}" 
                                     alt="Ảnh đại diện" class="img-thumbnail" width="150">
                            </div>
                            <div class="col-md-12">
                                <label for="anhDaiDien" class="form-label">Ảnh Đại Diện Mới (Không chọn nếu không đổi)</label>
                                <input type="file" class="form-control @error('anhDaiDien') is-invalid @enderror" id="anhDaiDien" name="anhDaiDien">
                                @error('anhDaiDien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Họ và Tên --}}
                            <div class="col-md-6">
                                <label for="ho" class="form-label">Họ</label>
                                <input type="text" class="form-control @error('ho') is-invalid @enderror" id="ho" name="ho" value="{{ old('ho', $giangvien->ho) }}">
                                @error('ho')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="ten" class="form-label">Tên</label>
                                <input type="text" class="form-control @error('ten') is-invalid @enderror" id="ten" name="ten" value="{{ old('ten', $giangvien->ten) }}">
                                @error('ten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email và SĐT --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $giangvien->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="sdt" class="form-label">Số Điện Thoại</label>
                                <input type="text" class="form-control @error('sdt') is-invalid @enderror" id="sdt" name="sdt" value="{{ old('sdt', $giangvien->sdt) }}">
                                @error('sdt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                             {{-- Mật khẩu & Nhập lại mật khẩu --}}
                             <div class="col-md-6">
                                <label for="matKhau" class="form-label">Mật khẩu (Không nhập nếu không đổi)</label>
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

                            {{-- Chức vụ và Bộ môn --}}
                            <div class="col-md-6">
                                <label for="chucVu" class="form-label">Chức Vụ</label>
                                <select class="form-control @error('chucVu') is-invalid @enderror" id="chucVu" name="chucVu">
                                    <option value="">-- Chọn Chức Vụ --</option>
                                    @foreach ($chucvus as $chucVu)
                                        <option value="{{ $chucVu->maChucVu }}" {{ old('chucVu', $giangvien->chucVu) == $chucVu->maChucVu ? 'selected' : '' }}>
                                            {{ $chucVu->tenChucVu }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('chucVu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="boMon" class="form-label">Bộ Môn</label>
                                <select class="form-control @error('boMon_id') is-invalid @enderror" id="boMon_id" id="boMon" name="boMon">
                                    <option value="">-- Chọn Bộ Môn --</option>
                                    @foreach ($bomons as $boMon)
                                        <option value="{{ $boMon->maBoMon }}" {{ old('boMon', $giangvien->boMon_id) == $boMon->maBoMon ? 'selected' : '' }}>
                                            {{ $boMon->tenBoMon }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('boMon_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- Nút bấm --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('giangvien.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                            <button type="submit" class="btn btn-primary btn-lg">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
