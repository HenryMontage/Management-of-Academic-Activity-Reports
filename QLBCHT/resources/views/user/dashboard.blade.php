@extends('layouts.user')
@section('page-title', "Trang Chủ")
<?php 
    $guard = session('current_guard');
    $user = Auth::guard($guard)->user(); 
    $gv = \App\Models\GiangVien::with('chucVuObj.quyen')->find($user->maGiangVien);

    $quyen = $current_quyen ?? auth()->user()->quyen ?? auth()->user()->chucVu->quyen ?? null;
    $dsQuyen = $user->quyen?->nhomRoute ?? $gv->chucVuObj?->quyen?->nhomRoute ?? [];   
    
    $features = config('home_data.features');
    $featuresChucNang = config('home_data.featuresChucNang');
?>

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h1 class="display-5 mb-3">Hệ Thống Quản Lý Sinh Hoạt Học Thuật</h1>
                    {{-- <p class="lead">
                        Chào mừng bạn đến với hệ thống quản lý báo cáo học thuật của Trường Đại học Nha Trang.
                        Đây là nơi giảng viên và nhân viên có thể quản lý, tạo lập và theo dõi các báo cáo học thuật.
                    </p> --}}
                </div>
            </div>
        </div>
    </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        @if(auth()->guard('giang_viens')->check())
                            <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Quy trình làm việc dành cho Giảng viên</h5>
                        @else
                            <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Quy trình làm việc dành cho PĐBCL</h5>
                        @endif
                        
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="row">
                                @foreach ($features as $item)
                                @if(in_array($item['quyen'], $dsQuyen))
                                    <div class="col-md-3 text-center mb-4">
                                        <div class="timeline-step">
                                            <div class="timeline-number">{{ $item['step'] }}</div>
                                            <div class="timeline-icon bg-{{ $item['color'] }} text-white">
                                                <i class="{{ $item['icon'] }} fa-2x"></i>
                                            </div>
                                            <h5 class="mt-3">{{ $item['title'] }}</h5>
                                            <p>{{ $item['desc'] }}</p>
                                            {{-- <a href="{{ route($item['route_name']) }}" class="btn btn-outline-{{ $item['color'] }}">
                                                <i class="{{ $item['icon'] }} me-1"></i> {{ $item['title'] }}
                                            </a> --}}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chức năng chi tiết cho giảng viên và PĐBCL -->
        <div class="row g-4">
            @foreach ($featuresChucNang as $item)
                @if(in_array($item['quyen'], $dsQuyen))
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100 border-{{ $item['color'] }} border-top border-4">
                            <div class="card-body d-flex flex-column">
                                <div class="text-center mb-3">
                                    <i class="{{ $item['icon'] }} fa-3x text-{{ $item['color'] }}"></i>
                                </div>
                                <h5 class="card-title text-center">{{ $item['title'] }}</h5>
                                <p class="card-text flex-grow-1">{{ $item['desc'] }}</p>
                                <div class="mt-3">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($item['sub_features'] as $sub)
                                            <li class="list-group-item">
                                                <i class="fas fa-check-circle text-success me-2"></i>{{ $sub }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <a href="{{ route($item['route_name']) }}" class="btn btn-{{ $item['color'] }} mt-auto {{ $item['color'] === 'info' ? 'text-white' : '' }}">
                                    <i class="{{ $item['icon'] }} me-1"></i> {{ Str::headline($item['title']) }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
</div>

<style>
.timeline-step {
    position: relative;
    padding: 20px;
    transition: all 0.3s ease;
}

.timeline-number {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #6c757d;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    z-index: 2;
}

.timeline-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 15px auto;
}

.border-top {
    border-top-width: 4px !important;
}
</style>
@endsection
