@extends('layouts.user')

@section('content')
<div class="container">
    <h3>Nộp Báo Cáo</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('baocao.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="tenBaoCao" class="form-label">Tên báo cáo</label>
            <input type="text" class="form-control" id="tenBaoCao" name="tenBaoCao" required>
        </div>

        <div class="mb-3">
            <label for="ngayNop" class="form-label">Ngày nộp</label>
            <input type="datetime-local" class="form-control" id="ngayNop" name="ngayNop" required>
        </div>

        <div class="mb-3" style="display: none">
            <label for="dinhDang" class="form-label">Định dạng</label>
            <input type="text" class="form-control" value="pdf,docx" id="dinhDang" name="dinhDang" placeholder="PDF/DOCX/PPTX" required>
        </div>

        <div class="mb-3">
            <label for="tomTat" class="form-label">Tóm tắt</label>
            <textarea class="form-control" name="tomTat" id="tomTat" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="files" class="form-label">Chọn file báo cáo</label>
            <input type="file" class="form-control" name="files[]" multiple required>
            <small class="form-text text-muted">Chỉ chấp nhận .pdf, .docx, .ppt, .pptx</small>
        </div>

        <button type="submit" class="btn btn-primary">Nộp báo cáo</button>
    </form>
</div>
@endsection