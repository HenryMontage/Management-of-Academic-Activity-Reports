@extends('layouts.user')

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Gửi Biên Bản Mới</h2>

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

                    <form action="{{ route('bienban.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            {{-- Chọn lịch báo cáo --}}
                            <div class="col-md-12">
                                <label for="lich_bao_cao_id" class="form-label">Chủ đề Sinh Hoạt Học Thuật</label>
                                <select class="form-select @error('lich_bao_cao_id') is-invalid @enderror" id="lich_bao_cao_id" name="lich_bao_cao_id">
                                    <option value="">-- Chọn chủ đề --</option>
                                    @foreach($lichBaoCaos as $lichBaoCao)
                                        <option value="{{ $lichBaoCao->maLich }}" {{ old('lich_bao_cao_id') == $lichBaoCao->maLich ? 'selected' : '' }}>
                                            {{ $lichBaoCao->chuDe }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lich_bao_cao_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- File biên bản --}}
                            <div class="col-md-12">
                                <label for="fileBienBan" class="form-label">File Biên Bản</label>
                                <input type="file" class="form-control @error('fileBienBan') is-invalid @enderror" id="fileBienBan" name="fileBienBan">
                                @error('fileBienBan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Nút bấm --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('bienban.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                            <button type="submit" class="btn btn-primary btn-lg">Gửi Biên Bản</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
