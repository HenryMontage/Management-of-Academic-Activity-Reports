
@extends('layouts.user')

@section('page-title', "Cập Nhật Lịch Báo Cáo")

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Cập Nhật Lịch Báo Cáo</h2>

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

                    <form action="{{ route('lichbaocao.update', $lich->maLich) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            {{-- Chủ Đề --}}
                            <div class="col-md-12">
                                <label for="chuDe" class="form-label">Chủ Đề</label>
                                <input type="text" class="form-control @error('chuDe') is-invalid @enderror" id="chuDe" name="chuDe" value="{{ old('chuDe', $lich->chuDe) }}">
                                @error('chuDe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Ngày Báo Cáo --}}
                            <div class="col-md-6">
                                <label for="ngayBaoCao" class="form-label">Ngày Báo Cáo</label>
                                <input type="date" class="form-control @error('ngayBaoCao') is-invalid @enderror" id="ngayBaoCao" name="ngayBaoCao" value="{{ old('ngayBaoCao', $lich->ngayBaoCao) }}">
                                @error('ngayBaoCao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Giờ Báo Cáo --}}
                            <div class="col-md-6">
                                <label for="gioBaoCao" class="form-label">Giờ Báo Cáo</label>
                                <input type="time" class="form-control @error('gioBaoCao') is-invalid @enderror" id="gioBaoCao" name="gioBaoCao" value="{{ old('gioBaoCao', $lich->gioBaoCao) }}">
                                @error('gioBaoCao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                             {{-- Hạn ngày nộp --}}
                             <div class="col-md-6">
                                <label for="hanNgayNop" class="form-label">Hạn Ngày Nộp</label>
                                <input type="date" class="form-control @error('hanNgayNop') is-invalid @enderror" id="hanNgayNop" name="hanNgayNop" value="{{ old('hanNgayNop', $lich->hanNgayNop) }}">
                                @error('hanNgayNop')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Hạn giờ nộp --}}
                            <div class="col-md-6">
                                <label for="hanGioNop" class="form-label">Hạn Giờ Nộp</label>
                                <input type="time" class="form-control @error('hanGioNop') is-invalid @enderror" id="hanGioNop" name="hanGioNop" value="{{ old('hanGioNop', $lich->hanGioNop) }}">
                                @error('hanGioNop')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Bộ Môn --}}
                            <div class="col-md-12">
                                <label for="boMon_id" class="form-label">Bộ Môn</label>
                                <select name="boMon_id" id="boMon_id" class="form-control @error('boMon_id') is-invalid @enderror">
                                    @foreach($boMons as $boMon)
                                        <option value="{{ $boMon->maBoMon }}" {{ old('boMon_id', $lich->boMon_id) == $boMon->maBoMon ? 'selected' : '' }}>
                                            {{ $boMon->tenBoMon }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('boMon_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Giảng Viên Phụ Trách --}}
                            <div class="col-md-12">
                                <label class="form-label">Giảng Viên Phụ Trách</label>
                                <div id="giangVienContainer" class="border p-2 row">
                                    @foreach($giangViens as $key => $giangVien)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input type="checkbox" name="giangVienPhuTrach[]" value="{{ $giangVien->maGiangVien }}"
                                                    class="form-check-input"
                                                    {{ in_array($giangVien->maGiangVien, $lich->giangVienPhuTrach->pluck('maGiangVien')->toArray()) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $giangVien->ho }} {{ $giangVien->ten }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        {{-- Nút bấm --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('lichbaocao.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                            <button type="submit" class="btn btn-primary btn-lg">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
   $(document).ready(function() {
    let selectedGiangVien = new Set($('input[name="giangVienPhuTrach[]"]:checked').map(function() {
        return this.value;
    }).get());

    $('#boMon_id').change(function() {
        var boMonId = $(this).val();
        $('#giangVienContainer').html('<p>Đang tải danh sách giảng viên...</p>');

        $.ajax({
            url: `/lichbaocao/giangviens/${boMonId}`,
            type: "GET",
            dataType: "json",
            success: function(data) {
                var giangVienHtml = "";
                if (data.length === 0) {
                    giangVienHtml = "<p>Không có giảng viên nào.</p>";
                } else {
                    data.forEach(function(giangVien, index) {
                        if (index % 3 === 0) giangVienHtml += '<div class="row">';

                        let checked = selectedGiangVien.has(giangVien.maGiangVien) ? 'checked' : '';

                        giangVienHtml += `
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" name="giangVienPhuTrach[]" value="${giangVien.maGiangVien}" class="form-check-input" ${checked}>
                                    <label class="form-check-label">${giangVien.ho} ${giangVien.ten}</label>
                                </div>
                            </div>`;

                        if ((index + 1) % 3 === 0) giangVienHtml += '</div>';
                    });
                }
                $('#giangVienContainer').html(giangVienHtml);

                // Cập nhật lại danh sách giảng viên được chọn sau khi load lại
                $('input[name="giangVienPhuTrach[]"]').change(function() {
                    if (this.checked) {
                        selectedGiangVien.add(this.value);
                    } else {
                        selectedGiangVien.delete(this.value);
                    }
                });
            }
        });
    });
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

</script>

    
@endsection
