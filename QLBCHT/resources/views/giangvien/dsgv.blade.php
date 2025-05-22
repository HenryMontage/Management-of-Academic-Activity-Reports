@extends('layouts.user')

@section('page-title', "Danh Sách Giảng Viên Theo Bộ Môn")

@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="fas fa-users me-2"></i>Danh Sách Giảng Viên</h4>
        </div>

        <div class="form-body">
            {{-- Tìm kiếm --}}
            <div class="row mb-4 justify-content-center">
                <form action="{{ route('giangvien.dsgv') }}" method="GET"
                    class="d-flex flex-wrap align-items-center gap-2 justify-content-center">
                    <input type="text" name="keyword"
                        class="form-control form-control-sm"
                        placeholder="Tìm theo tên bộ môn..."
                        value="{{ request('keyword') }}"
                        style="width: 350px; height: 45px;">
                    <button class="btn btn-primary" type="submit" style="height: 45px;">Tìm kiếm</button>
                    <a href="{{ route('giangvien.dsgv') }}" class="btn btn-success" style="height: 45px;min-width: 100px; align-content: center;">Làm mới</a>
                </form>
            </div>

            <div class="row">
                @forelse ($boMons as $boMon)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm border-primary border-top border-4 h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="text-center mb-3">
                                    <i class="fas fa-chalkboard-teacher fa-2x text-primary"></i>
                                </div>
                                <h5 class="card-title text-center">{{ $boMon->tenBoMon }}</h5>
                                <p class="card-text text-center text-muted">Số giảng viên: <strong>{{ $boMon->giang_viens_count }}</strong></p>

                                <div class="text-center mt-auto">
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-{{ $boMon->maBoMon }}">
                                        <i class="fas fa-eye me-1"></i> Xem chi tiết
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modal-{{ $boMon->maBoMon }}" tabindex="-1" aria-labelledby="modalLabel-{{ $boMon->maBoMon }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="modalLabel-{{ $boMon->maBoMon }}">Giảng viên - {{ $boMon->tenBoMon }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                </div>
                                <div class="modal-body">
                                    @if ($boMon->giangViens->isEmpty())
                                        <p class="text-center">Không có giảng viên nào trong bộ môn này.</p>
                                    @else
                                        <div class="list-group">
                                            @foreach ($boMon->giangViens as $gv)
                                                <div class="list-group-item d-flex align-items-center">
                                                <img src="{{ asset('storage/' . ($gv->anhDaiDien ?? 'anhDaiDiens/anhmacdinh.jpg')) }}" 
                                            alt="Ảnh đại diện" 
                                            class="rounded-circle me-2"
                                            style="width: 32px; height: 32px; object-fit: cover;"
                                            onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{  urlencode($gv->ho . ' ' . $gv->ten) }}&background=0D8ABC&color=fff';">
                                                    <div>
                                                        <strong>{{ $gv->ho }} {{ $gv->ten }}</strong><br>
                                                        <small class="text-muted">{{ $gv->email }}</small>
                                                    </div>
                                                    <span class="badge bg-primary ms-auto">{{ $gv->chucVuObj->tenChucVu ?? 'Không rõ' }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                {{-- <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center">
                        <h5>Không có bộ môn phù hợp.</h5>
                    </div>
                @endforelse
            </div>

            {{-- Phân trang --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $boMons->appends(['keyword' => request('keyword')])->links() }}
            </div>
        </div>
        
    </div>
</div>
@endsection
