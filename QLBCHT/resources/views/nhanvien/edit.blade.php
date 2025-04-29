@extends('layouts.app')

@section('page-title', "Chỉnh sửa Nhân Viên")

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Chỉnh sửa Nhân Viên</h2>

                    <form action="{{ route('nhanvien.update', $nhanvien->maNV) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            {{-- Mã NV (readonly) & Ảnh --}}
                            <div class="col-md-6">
                                <label for="maNV" class="form-label">Mã Nhân Viên</label>
                                <input type="text" class="form-control" value="{{ $nhanvien->maNV }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="anhDaiDien" class="form-label">Ảnh đại diện</label>
                                <input type="file" class="form-control @error('anhDaiDien') is-invalid @enderror" name="anhDaiDien">
                                @error('anhDaiDien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($nhanvien->anhDaiDien)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $nhanvien->anhDaiDien) }}" alt="Ảnh đại diện" width="100">
                                    </div>
                                @endif
                            </div>

                            {{-- Họ & Tên --}}
                            <div class="col-md-6">
                                <label for="ho" class="form-label">Họ</label>
                                <input type="text" class="form-control @error('ho') is-invalid @enderror" name="ho" value="{{ old('ho', $nhanvien->ho) }}">
                                @error('ho')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="ten" class="form-label">Tên</label>
                                <input type="text" class="form-control @error('ten') is-invalid @enderror" name="ten" value="{{ old('ten', $nhanvien->ten) }}">
                                @error('ten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email & SĐT --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $nhanvien->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="sdt" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control @error('sdt') is-invalid @enderror" name="sdt" value="{{ old('sdt', $nhanvien->sdt) }}">
                                @error('sdt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Nút --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('nhanvien.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                            <button type="submit" class="btn btn-success btn-lg">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
