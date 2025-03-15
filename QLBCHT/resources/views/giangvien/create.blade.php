{{-- @extends('layouts.app')
@section('page-title', "Thêm Giảng Viên")
@section('content')
    <div class="container">
        <h1>Thêm Giảng Viên</h1>
        <form action="{{ route('giangvien.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Mã Giảng Viên</label>
                    <input type="text" value="{{ old('maGiangVien') }}" name="maGiangVien" class="form-control">
                    @error('maGiangVien')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="matKhau" class="form-control">
                    @error('matKhau')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Họ</label>
                    <input type="text" value="{{ old('ho') }}" name="ho" class="form-control">
                    @error('ho')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tên</label>
                    <input type="text" value="{{ old('ten') }}" name="ten" class="form-control">
                    @error('ten')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" value="{{ old('sdt') }}" name="sdt" class="form-control">
                    @error('sdt')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" value="{{ old('email') }}" name="email" class="form-control">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Chức vụ</label>
                    <select name="chucVu" class="form-control">
                        <option value="">-- Chọn chức vụ --</option>
                        @foreach($chucVus as $chucVu)
                            <option value="{{ $chucVu->maChucVu }}">{{ $chucVu->tenChucVu }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Bộ môn</label>
                    <select name="boMon_id" class="form-control">
                        <option value="">-- Chọn bộ môn --</option>
                        @foreach($boMons as $boMon)
                            <option value="{{ $boMon->maBoMon }}">{{ $boMon->tenBoMon }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row-mb-3">
                <div class="col-md-6">
                    <label for="avatar">Ảnh đại diện:</label>
                <input type="file" name="anhDaiDien" class="form-control">
                @error('anhDaiDien')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Thêm Giảng Viên</button>
        </form>
    </div>
@endsection --}}

@extends('layouts.app')

@section('page-title', "Thêm Giảng Viên")

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Thêm Giảng Viên</h2>

                    <form action="{{ route('giangvien.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            {{-- Mã Giảng Viên & Ảnh đại diện --}}
                            <div class="col-md-6">
                                <label for="maGiangVien" class="form-label">Mã Giảng Viên</label>
                                <input type="text" class="form-control @error('maGiangVien') is-invalid @enderror" id="maGiangVien" name="maGiangVien" value="{{ old('maGiangVien') }}">
                                @error('maGiangVien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="anhDaiDien" class="form-label">Ảnh đại diện</label>
                                <input type="file" class="form-control @error('anhDaiDien') is-invalid @enderror" id="anhDaiDien" name="anhDaiDien">
                                @error('anhDaiDien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Họ & Tên --}}
                            <div class="col-md-6">
                                <label for="ho" class="form-label">Họ</label>
                                <input type="text" class="form-control @error('ho') is-invalid @enderror" id="ho" name="ho" value="{{ old('ho') }}">
                                @error('ho')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="ten" class="form-label">Tên</label>
                                <input type="text" class="form-control @error('ten') is-invalid @enderror" id="ten" name="ten" value="{{ old('ten') }}">
                                @error('ten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email & Số điện thoại --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="sdt" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control @error('sdt') is-invalid @enderror" id="sdt" name="sdt" value="{{ old('sdt') }}">
                                @error('sdt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Mật khẩu & Nhập lại mật khẩu --}}
                            <div class="col-md-6">
                                <label for="matKhau" class="form-label">Mật khẩu</label>
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

                            {{-- Chức vụ & Bộ môn --}}
                            <div class="col-md-6">
                                <label for="chucVu" class="form-label">Chức vụ</label>
                                <select class="form-select @error('chucVu') is-invalid @enderror" id="chucVu" name="chucVu">
                                    <option value="">-- Chọn chức vụ --</option>
                                    @foreach($chucVus as $chucVu)
                                        <option value="{{ $chucVu->maChucVu }}">{{ $chucVu->tenChucVu }}</option>
                                    @endforeach
                                </select>
                                @error('chucVu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="boMon_id" class="form-label">Bộ môn</label>
                                <select class="form-select @error('boMon_id') is-invalid @enderror" id="boMon_id" name="boMon_id">
                                    <option value="">-- Chọn bộ môn --</option>
                                    @foreach($boMons as $boMon)
                                        <option value="{{ $boMon->maBoMon }}">{{ $boMon->tenBoMon }}</option>
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
                            <button type="submit" class="btn btn-primary btn-lg">Thêm Giảng Viên</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
