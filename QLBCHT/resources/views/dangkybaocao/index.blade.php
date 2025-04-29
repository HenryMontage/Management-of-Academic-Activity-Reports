{{-- @extends('layouts.user')

@section('content')
<h2>Danh sách đăng ký báo cáo</h2>

<a href="{{ route('dangkybaocao.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Đăng ký báo cáo
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Chủ đề</th>
            <th>Bộ môn</th>
            <th>Khoa</th>
            <th>Ngày giờ</th>
            <th>Địa điểm</th>
            <th>Trạng thái</th>
            <th>Giảng viên phụ trách - Tên báo cáo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dangKyBaoCaos as $dk)
        <tr>
            <td>{{ $dk->lichBaoCao->chuDe ?? '[Không rõ]' }}</td>

            <td>{{ $dk->lichBaoCao->boMon->tenBoMon ?? '[Không rõ]' }}</td>

            <td>{{ $dk->lichBaoCao->boMon->khoa->tenKhoa ?? '[Không rõ]' }}</td>

            <td>{{ $dk->lichBaoCao->ngayBaoCao }} - {{ $dk->lichBaoCao->gioBaoCao }}</td>

            <td>VP BM {{ $dk->lichBaoCao->boMon->tenBoMon ?? '' }}</td>

            <td>{{ $dk->trangThai ?? '' }}</td>
            <td>
                <ul class="mb-0 ps-3">
                    @foreach($dk->baoCaos as $bc)
                        <li>
                            {{ $bc->giangVien->ho }} {{ $bc->giangVien->ten }} - 
                            <a href="{{ $bc->duongDanFile }}" target="_blank">{{ $bc->tenBaoCao }}</a>
                        </li>
                    @endforeach
                </ul>
            </td>
            <td>
                <form action="{{ route('dangkybaocao.destroy', $dk->maDangKyBaoCao) }}" method="POST" onsubmit="return confirm('Xoá đăng ký này?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Xoá</button>
                </form>
                <a href="{{ route('dangkybaocao.export', ['lich_id' => $dk->lichBaoCao->maLich]) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-file-export"></i> Xuất phiếu PDF
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection --}}

@extends('layouts.user')

@section('content')
<h2 class="mb-4">Danh sách phiếu đăng ký </h2>

<a href="{{ route('dangkybaocao.create') }}" class="btn btn-primary mb-4">
    <i class="fas fa-plus"></i> Đăng ký 
</a>

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
