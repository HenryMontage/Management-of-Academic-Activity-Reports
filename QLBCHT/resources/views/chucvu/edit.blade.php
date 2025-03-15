@extends('layouts.app')

@section('page-title', "Cập Nhật Chức Vụ")

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Cập Nhật Chức Vụ {{ $chucvu->tenChucVu }}</h2>

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

                    <form action="{{ route('chucvu.update', $chucvu->maChucVu) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            {{-- Tên Chức Vụ --}}
                            <div class="col-md-12">
                                <label for="tenChucVu" class="form-label">Tên Chức Vụ</label>
                                <input type="text" class="form-control @error('tenChucVu') is-invalid @enderror" id="tenChucVu" name="tenChucVu" value="{{ old('tenChucVu', $chucvu->tenChucVu) }}">
                                @error('tenChucVu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Quyền --}}
                            <div class="col-md-12">
                                <label for="quyen_id" class="form-label">Quyền</label>
                                <select name="quyen_id" id="quyen_id" class="form-control @error('quyen_id') is-invalid @enderror">
                                    <option value="">-- Chọn Quyền --</option>
                                    @foreach($quyens as $quyen)
                                        <option value="{{ $quyen->maQuyen }}" {{ $chucvu->quyen_id == $quyen->maQuyen ? 'selected' : '' }}>
                                            {{ $quyen->tenQuyen }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('quyen_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- Nút bấm --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('chucvu.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                            <button type="submit" class="btn btn-primary btn-lg">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
