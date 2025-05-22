

@extends('layouts.user')

@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header">
            <h4 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Tạo Lịch Sinh Hoạt Học Thuật</h4>
        </div>
        <div class="form-body">
            <form action="{{ route('lichbaocao.store') }}" method="POST">
                @csrf

                {{-- Chủ đề --}}
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Chủ đề</h5>
                    </div>
                    <div class="section-body">
                        <input type="text" class="form-control @error('chuDe') is-invalid @enderror" name="chuDe" value="{{ old('chuDe') }}" placeholder="Nhập chủ đề">
                        @error('chuDe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Thời gian báo cáo --}}
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Thời gian Báo Cáo</h5>
                    </div>
                    <div class="section-body row g-3">
                        <div class="col-md-6">
                            <label for="ngayBaoCao" class="form-label">Ngày báo cáo</label>
                            <input type="date" class="form-control @error('ngayBaoCao') is-invalid @enderror" id="ngayBaoCao" name="ngayBaoCao">
                            @error('ngayBaoCao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="gioBaoCao" class="form-label">Giờ báo cáo</label>
                            <input type="time" class="form-control @error('gioBaoCao') is-invalid @enderror" id="gioBaoCao" name="gioBaoCao">
                            @error('gioBaoCao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Hạn nộp báo cáo --}}
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-hourglass-end me-2"></i>Hạn Nộp Báo Cáo</h5>
                    </div>
                    <div class="section-body row g-3">
                        <div class="col-md-6">
                            <label for="hanNgayNop" class="form-label">Hạn ngày nộp</label>
                            <input type="date" class="form-control @error('hanNgayNop') is-invalid @enderror" id="hanNgayNop" name="hanNgayNop">
                            @error('hanNgayNop')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="hanGioNop" class="form-label">Hạn giờ nộp</label>
                            <input type="time" class="form-control @error('hanGioNop') is-invalid @enderror" id="hanGioNop" name="hanGioNop">
                            @error('hanGioNop')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Bộ môn--}}
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fa-solid fa-book-open-reader me-1"></i>Bộ Môn</h5>
                    </div>
                    <div class="section-body row g-3">
                        <div class="col-md-12">
                            <select name="boMon_id" id="boMonSelect" class="form-control @error('boMon_id') is-invalid @enderror">
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
                </div>

                 {{-- Giảng viên phụ trách --}}
                 <div class="form-section">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Giảng Viên Phụ Trách</h5>
                    </div>
                    <div class="section-body row g-3">

                        <div class="col-md-12">
                            <div id="giangVienList">
                                <p class="text-muted">Vui lòng chọn bộ môn trước</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="{{ route('lichbaocao.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#boMonSelect').change(function() {
            let boMon_id = $(this).val();
            $('#giangVienList').html('<p>Đang tải danh sách giảng viên...</p>');

            if (boMon_id) {
                $.ajax({
                    url: `/lichbaocao/giangviens/${boMon_id}`,
                    type: 'GET',
                    success: function(data) {
                        let html = '';
                        console.log(data);
                        if (Array.isArray(data)) {
                            if (data.length > 0) {
                                html += '<div class="row">';
                                data.forEach(function(giangVien, index) {
                                    html += `
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="giangVienPhuTrach[]" value="${giangVien.maGiangVien}" id="gv${index}">
                                                <label class="form-check-label" for="gv${index}">
                                                    ${giangVien.ho} ${giangVien.ten}
                                                </label>
                                            </div>
                                        </div>
                                    `;
                                });
                                html += '</div>';
                            } else {
                                html = '<p class="text-danger">Bộ môn này không có giảng viên.</p>';
                            }
                        } else {
                            html = '<p class="text-danger">Dữ liệu trả về không hợp lệ.</p>';
                        }
                        $('#giangVienList').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error("Lỗi AJAX:", status, error);
                        $('#giangVienList').html('<p class="text-danger">Bộ môn này không có giảng viên</p>');
                    }
                });
            } else {
                $('#giangVienList').html('<p>Vui lòng chọn bộ môn trước</p>');
            }
        });

        $(document).ready(function() {
            $('#ngayBaoCao').change(function () {
                let ngayBaoCao = new Date(this.value);
                let minDate = new Date(); // Hôm nay
                let maxDate = new Date(ngayBaoCao);
                maxDate.setDate(maxDate.getDate() - 3); // Ngày báo cáo - 3 ngày

                let minDateFormatted = minDate.toISOString().split("T")[0];
                let maxDateFormatted = maxDate.toISOString().split("T")[0];

                $('#hanNgayNop').attr('min', minDateFormatted);
                $('#hanNgayNop').attr('max', maxDateFormatted);
            });
        });
    });
</script>
@endsection