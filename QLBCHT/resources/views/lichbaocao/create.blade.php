@extends('layouts.user')

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Tạo Lịch Sinh Hoạt Học Thuật</h2>

                    {{-- Hiển thị lỗi nếu có --}}
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif --}}

                    <form action="{{ route('lichbaocao.store')}}" method="POST">
                        @csrf
                        <div class="row g-3">
                            {{-- Chủ đề --}}
                            <div class="col-md-12">
                                <label for="chuDe" class="form-label">Chủ đề</label>
                                <input type="text" class="form-control @error('chuDe') is-invalid @enderror" id="chuDe" name="chuDe" value="{{ old('chuDe') }}">
                                @error('chuDe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Ngày báo cáo --}}
                            <div class="col-md-6">
                                <label for="ngayBaoCao" class="form-label">Ngày báo cáo</label>
                                <input type="date" class="form-control @error('ngayBaoCao') is-invalid @enderror" id="ngayBaoCao" name="ngayBaoCao">
                                @error('ngayBaoCao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Giờ báo cáo --}}
                            <div class="col-md-6">
                                <label for="gioBaoCao" class="form-label">Giờ báo cáo</label>
                                <input type="time" class="form-control @error('gioBaoCao') is-invalid @enderror" id="gioBaoCao" name="gioBaoCao">
                                @error('gioBaoCao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Hạn ngày nộp --}}
                            <div class="col-md-6">
                                <label for="hanNgayNop" class="form-label">Hạn ngày nộp</label>
                                <input type="date" class="form-control @error('hanNgayNop') is-invalid @enderror" id="hanNgayNop" name="hanNgayNop">
                                @error('hanNgayNop')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Hạn giờ nộp --}}
                            <div class="col-md-6">
                                <label for="hanGioNop" class="form-label">Hạn giờ nộp</label>
                                <input type="time" class="form-control @error('hanGioNop') is-invalid @enderror" id="hanGioNop" name="hanGioNop">
                                @error('hanGioNop')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Bộ môn --}}
                            <div class="col-md-6">
                                <label for="boMon_id" class="form-label">Bộ môn</label>
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

                            {{-- Giảng viên phụ trách --}}
                            <div class="col-md-6">
                                <label for="giangVienPhuTrach" class="form-label">Giảng viên phụ trách</label>
                                <div id="giangVienList">
                                    <p class="text-muted">Vui lòng chọn bộ môn trước</p>
                                </div>
                            </div>
                        </div>

                        {{-- Nút bấm --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('lichbaocao.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                            <button type="submit" class="btn btn-primary btn-lg">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
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
                        if (data.length > 0) {
                            data.forEach(function(giangVien) {
                                html += `
                                    <label>
                                        <input type="checkbox" name="giangVienPhuTrach[]" value="${giangVien.maGiangVien}">
                                        ${giangVien.ho} ${giangVien.ten}
                                    </label><br>
                                `;
                            });
                        } else {
                            html = '<p>Không có giảng viên nào trong bộ môn này.</p>';
                        }
                        $('#giangVienList').html(html);
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
