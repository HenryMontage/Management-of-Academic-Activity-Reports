

@extends('layouts.user')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Danh Sách Phiếu Đăng Ký</h3>
    <a href="{{ route('dangkybaocao.create') }}" class="btn btn-primary">Gửi Phiếu Đăng Ký </a>
</div>

<div class="row">
    @foreach($dangKyBaoCaos as $dk)

    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title text-primary">{{ $dk->lichBaoCao->chuDe ?? '[Không rõ]' }}</h5>
                
                <p class="mb-1"><strong>Bộ môn:</strong> {{ $dk->lichBaoCao->boMon->tenBoMon ?? '[Không rõ]' }}</p>
                <p class="mb-1"><strong>Khoa:</strong> {{ $dk->lichBaoCao->boMon->khoa->tenKhoa ?? '[Không rõ]' }}</p>
                <p class="mb-1"><strong>Ngày giờ:</strong> {{ $dk->lichBaoCao->ngayBaoCao }} - {{ $dk->lichBaoCao->gioBaoCao }}</p>
                <p class="mb-1"><strong>Địa điểm:</strong> VP BM {{ $dk->lichBaoCao->boMon->tenBoMon ?? '' }}</p>
                <p class="mb-1"><strong>Trạng thái:</strong> {{ $dk->trangThai ?? '' }}</p>

                <div class="mb-2">
                    <strong>Giảng viên & Báo cáo:</strong>
                    <ul class="ps-3 mb-0">
                        @foreach($dk->baoCaos as $bc)
                        <li>
                            {{ $bc->giangVien->ho }} {{ $bc->giangVien->ten }} -
                            <a href="{{ $bc->duongDanFile }}" target="_blank">{{ $bc->tenBaoCao }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-auto d-flex justify-content-between">
                    <form action="{{ route('dangkybaocao.destroy', $dk->maDangKyBaoCao) }}" method="POST" onsubmit="return confirm('Xoá đăng ký này?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Xoá</button>
                    </form>
                    <a href="{{ route('dangkybaocao.export', ['lich_id' => $dk->lichBaoCao->maLich]) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-export"></i> Xuất PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="d-flex justify-content-center mt-4">
        {{ $dangKyBaoCaos->links() }}
    </div>
</div>
@endsection
