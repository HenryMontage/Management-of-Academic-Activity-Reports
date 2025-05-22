
@extends('layouts.user')

@section('content')
<div class="fixed-container">
    <div class="form-container">
        <div class="form-header d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="fas fa-file-alt me-2"></i>Đăng Ký Tham Gia SHHT</h4>
        </div>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Đóng">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Đóng">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="form-body">
            <div class="row">
                <div class="row mb-4 justify-content-center">
                    <form action="{{ route('lichbaocaodangky.dangky') }}" method="GET" 
                        class="d-flex flex-wrap align-items-center gap-2 justify-content-center" style="max-width: 100%;">
                        
                        <input type="text" name="keyword" 
                               class="form-control form-control-sm" 
                               placeholder="Nhập từ khóa (tên báo cáo)..." 
                               value="{{ request('keyword') }}" 
                               style="width: 350px; height: 45px; min-width: 250px;">
                        
                        <button class="btn btn-primary" type="submit" style="height: 45px; min-width: 100px;">
                            Tìm kiếm
                        </button>
                        
                        <a href="{{ route('lichbaocaodangky.dangky') }}" class="btn btn-success" style="height: 45px; min-width: 100px; align-content: center;">
                            Làm mới
                        </a>
                    </form>  
                </div>
                
                @forelse($lichBaoCaos as $lich)
                @php
                    $borderColor = match(true) {
                        in_array($lich->maLich, $lichDaDangKy) => 'danger', // đã đăng ký
                        default => 'primary', // chưa đăng ký
                    };
                @endphp
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100 border-{{ $borderColor }} border-top border-4">
                        
                            <div class="card-body d-flex flex-column">
                                <div class="text-center mb-2">    
                                    <i class="fa-solid fa-calendar-days text-{{ $borderColor }} fa-2x"></i>                            
                                </div>
                                <h6 class="card-title text-center">Chủ đề: {{ $lich->chuDe }}</h6>
                                <p class="card-text text-center text-muted mb-1">
                                    Ngày/giờ tổ chức: 
                                    <strong>{{ \Carbon\Carbon::parse($lich->ngayBaoCao)->format('d/m/Y') }}</strong>
                                    - </strong> {{ \Carbon\Carbon::parse($lich->gioBaoCao)->format('H:i') }}</strong>
                                </p>
                                <p class="card-text text-center text-muted">Bộ môn: <strong>{{ $lich->boMon->tenBoMon ?? 'Không xác định' }}</strong></p>
    
                                <!-- Kiểm tra xem giảng viên đã đăng ký chưa -->
                                <div class="d-flex justify-content-center gap-3 mt-3">
                                    @if(in_array($lich->maLich, $lichDaDangKy))
                                        <!-- Nếu đã đăng ký, hiển thị nút hủy -->
                                        <button class="btn btn-outline-danger btn-huy-dangky" data-id="{{ $lich->maLich }}" data-chude="{{ $lich->chuDe }}">Hủy đăng ký</button>
                                    @else
                                        <!-- Nếu chưa đăng ký, hiển thị nút đăng ký -->
                                        <button class="btn btn-outline-primary btn-dangky" data-id="{{ $lich->maLich }}" data-chude="{{ $lich->chuDe }}">Đăng ký</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal xác nhận đăng ký -->
                    <div class="modal fade" id="modalDangKy" tabindex="-1" role="dialog" aria-labelledby="modalDangKyLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form id="formDangKy" method="POST" action="{{ route('lichbaocaodangky.dangky.submit') }}">
                                @csrf
                                <input type="hidden" name="lich_bao_cao_id" id="lich_bao_cao_id">
                                <div class="modal-content">
                                    <div class="modal-header p-2" id="header-bg">
                                    <h5 class="modal-title" id="modalDangKyLabel">Xác Nhận Đăng Ký</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                    </div>
                                    <div class="modal-body">
                                         @if(in_array($lich->maLich, $lichDaDangKy))
                                        <!-- Nếu đã đăng ký, hiển thị nút hủy -->
                                            Bạn có chắc chắn muốn hủy đăng ký lịch báo cáo: <strong id="tenChuDe"></strong>?
                                        @else
                                            <!-- Nếu chưa đăng ký, hiển thị nút đăng ký -->
                                            Bạn có chắc chắn muốn đăng ký lịch báo cáo: <strong id="tenChuDe"></strong>?
                                        @endif
                                    {{-- Bạn có chắc chắn muốn đăng ký lịch báo cáo: <strong id="tenChuDe"></strong>? --}}
                                    </div>
                                    <div class="modal-footer p-2 d-flex justify-content-center">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" id="btn-color" class="btn">Xác nhận</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="d-flex justify-content-center">
                        <h4>Không Có Lịch Nào</h4>
                    </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $lichBaoCaos->links() }}
            </div>
        </div>
    </div>
</div>


{{-- @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Đóng">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Đóng">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
<div class="container">
    <div class="row">
        @foreach($lichBaoCaos as $lich)
        <div class="col-md-4">
            <div class="card mb-4 shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">{{ $lich->chuDe }}</h5>
                    <p class="card-text">
                        <strong>Ngày báo cáo:</strong> {{ \Carbon\Carbon::parse($lich->ngayBaoCao)->format('d/m/Y') }}<br>
                        <strong>Giờ báo cáo:</strong> {{ \Carbon\Carbon::parse($lich->gioBaoCao)->format('H:i') }}<br>
                        <strong>Bộ môn:</strong> {{ $lich->boMon->tenBoMon ?? 'Không xác định' }}
                    </p>

                    <!-- Kiểm tra xem giảng viên đã đăng ký chưa -->
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        @if(in_array($lich->maLich, $lichDaDangKy))
                        <!-- Nếu đã đăng ký, hiển thị nút hủy -->
                        <button class="btn btn-danger btn-huy-dangky" data-id="{{ $lich->maLich }}" data-chude="{{ $lich->chuDe }}">Hủy đăng ký</button>
                    @else
                        <!-- Nếu chưa đăng ký, hiển thị nút đăng ký -->
                        <button class="btn btn-primary btn-dangky" data-id="{{ $lich->maLich }}" data-chude="{{ $lich->chuDe }}">Đăng ký</button>
                    @endif
                    </div>
                    
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal xác nhận đăng ký -->
<div class="modal fade" id="modalDangKy" tabindex="-1" role="dialog" aria-labelledby="modalDangKyLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="formDangKy" method="POST" action="{{ route('lichbaocaodangky.dangky.submit') }}">
        @csrf
        <input type="hidden" name="lich_bao_cao_id" id="lich_bao_cao_id">
        <div class="modal-content">
          <div class="modal-header p-2" id="header-bg">
            <h5 class="modal-title" id="modalDangKyLabel">Xác Nhận Đăng Ký</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
          </div>
          <div class="modal-body">
            Bạn có chắc chắn muốn đăng ký lịch báo cáo: <strong id="tenChuDe"></strong>?
          </div>
          <div class="modal-footer p-2 d-flex justify-content-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            <button type="submit" id="btn-color" class="btn">Xác nhận</button>
          </div>
        </div>
    </form>
  </div>
</div> --}}
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Hiển thị modal khi giảng viên nhấn "Đăng ký"
        $('.btn-dangky').on('click', function() {
            const maLich = $(this).data('id');
            const chuDe = $(this).data('chude');
            $('#lich_bao_cao_id').val(maLich);
            $('#tenChuDe').text(chuDe);
            $('#modalDangKyLabel').css('color','#fff');
            $('#header-bg').css('background-color', '#0d6efd');
            $('#btn-color').css('background-color', '#0d6efd');
            $('#btn-color').css('color', '#fff');
            $('#modalDangKy').modal('show');
        });

        // Hiển thị modal khi giảng viên nhấn "Hủy đăng ký"
        $('.btn-huy-dangky').on('click', function() {
            const maLich = $(this).data('id');
            const chuDe = $(this).data('chude');
            $('#lich_bao_cao_id').val(maLich); // Cập nhật id lịch vào input ẩn
            $('#tenChuDe').text(chuDe); // Cập nhật tên chủ đề vào modal
            $('#modalDangKyLabel').text('Xác Nhận Hủy Đăng Ký'); // Cập nhật tiêu đề modal
            $('#modalDangKyLabel').css('color','#fff');
            $('#header-bg').css('background-color', '#dc3545');
            $('#btn-color').css('background-color', '#dc3545');
            $('#btn-color').css('color', '#fff');
            $('#formDangKy').attr('action', '{{ route('lichbaocaodangky.huy') }}'); // Thay đổi action của form
            $('#modalDangKy').modal('show'); // Hiển thị modal
        });
    });
</script>

@endsection

