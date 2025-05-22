@extends('layouts.user')
@section('content')

<div class="fixed-container">
    <div class="form-container">
        <div class="form-header">
            <h4 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Nộp Báo Cáo</h4>
        </div>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="form-body">
            <form action="{{ route('baocao.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="form-section">
                        <div class="col-md-12">
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Chủ đề</h5>
                            </div>
                            <div class="section-body">
                                <select class="form-select @error('lich_bao_cao_id') is-invalid @enderror" id="lich_bao_cao_id" name="lich_bao_cao_id">
                                    <option value="">-- Chọn chủ đề báo cáo --</option>
                                    @foreach($lichBaoCaos as $lichBaoCao)
                                        <option value="{{ $lichBaoCao->maLich }}">{{ $lichBaoCao->chuDe }}</option>
                                    @endforeach
                                </select>
                                @error('lich_bao_cao_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> 
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-header">
                            <h5 class="mb-0"><i class="fa-solid fa-file-pen"></i>Tên Báo Cáo - <i class="fa-solid fa-calendar-days"></i> Ngày Nộp</h5>
                        </div>
                        <div class="section-body row g-3">
                            <div class="col-md-6">
                                <label for="tenBaoCao" class="form-label">Tên báo cáo</label>
                                <input type="text" class="form-control @error('tenBaoCao') is-invalid @enderror" id="tenBaoCao" name="tenBaoCao" value="{{ old('tenBaoCao') }}" required>
                                @error('tenBaoCao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="ngayNop" class="form-label">Ngày nộp</label>
                                <input type="date" class="form-control @error('ngayNop') is-invalid @enderror" id="ngayNop" name="ngayNop"
                                    value="{{ old('ngayNop', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                                @error('ngayNop')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>   

                    <div class="col-md-6" style="display: none;">
                        <label for="dinhDang" class="form-label">Định dạng</label>
                        <input type="text" class="form-control" id="dinhDang" name="dinhDang" value="pdf,docx">
                    </div>


                    <div class="form-section">
                        <div class="col-md-12">
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fa-solid fa-square-pen"></i> Tóm Tắt Nội Dung</h5>
                            </div>
                            <div class="section-body">
                                <textarea class="form-control @error('tomTat') is-invalid @enderror" id="tomTat" name="tomTat" rows="4" required>{{ old('tomTat') }}</textarea>
                                @error('tomTat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> 
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="col-md-12">
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fa-solid fa-paperclip"></i> Chọn Tệp Báo Cáo</h5>
                            </div>
                            <div class="section-body">
                                <input type="file" class="form-control @error('files') is-invalid @enderror" name="files[]" multiple required>
                                <small class="form-text text-muted">Chỉ chấp nhận .pdf, .docx, .ppt, .pptx</small>
                                @error('files')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> 
                        </div>
                    </div>

                 
                </div>

                <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="{{ route('baocao.index') }}" class=" btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Nộp báo cáo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection