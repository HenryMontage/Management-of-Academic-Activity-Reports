@extends('layouts.user')

@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header">
            <h4 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Gửi Biên Bản</h4>
        </div>
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

        <div class="form-body">
            <form action="{{ route('bienban.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    {{-- Chọn lịch báo cáo --}}
                    <div class="form-section">
                        <div class="col-md-12">
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Chủ Đề Sinh Hoạt Học Thuật</h5>
                            </div>
                            <div class="section-body">
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
                        </div>
                    </div>
                   

                    {{-- File biên bản --}}
                    <div class="form-section">
                        <div class="col-md-12">
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fa-solid fa-file"></i> Chọn Tệp Biên Bản</h5>
                            </div>
                            <div class="section-body">
                                <input type="file" class="form-control @error('fileBienBan') is-invalid @enderror" id="fileBienBan" name="fileBienBan">
                                @error('fileBienBan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> 
                        </div>
                    </div>
                </div>

                {{-- Nút bấm --}}
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="{{ route('bienban.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">Gửi Biên Bản</button>
                </div>
            </form>
        </div>
    
    </div>
</div>


@endsection
