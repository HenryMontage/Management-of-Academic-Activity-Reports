
@extends('layouts.app')
@section('page-title', 'Trang Chủ')

@section('content')
<style>
    .chartjs-render-monitor {
        margin: 0 auto;
    }
</style>

<div class="container py-4">
    <div class="container py-3">
        <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-3 align-items-end">
            <div class="col-auto">
                <label for="from_date" class="form-label">Từ ngày</label>
                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-auto">
                <label for="to_date" class="form-label">Đến ngày</label>
                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success">Tìm</button>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Làm mới</a>
            </div>
        </form>
       
    </div>
    
    <div class="row mb-4">
        {{-- Cột trái: 3 ô thống kê --}}
        <div class="col-md-5">
            <div class="mb-3">
                <div class="mb-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h5 class="card-title">Lịch báo cáo </h5>
                            <p class="card-text h4">{{ $tongLichBaoCao }}</p>
                        </div>
                    </div>
                </div>
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Phiếu đăng ký đã xác nhận</h5>
                        <p class="card-text h4">{{ $phieuDuocXacNhan }}/{{ $tongPhieuDangKy }} tổng phiếu</p>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Báo cáo trong tháng</h5>
                        <p class="card-text h4">{{ $tongBaoCao }}</p>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Biên bản đã được xác nhận</h5>
                        <p class="card-text h4">{{ $bienBanDuocXacNhan }}/{{ $tongBienBan }}</p>
                    </div>
                </div>
            </div>
            
        </div>

        {{-- Cột phải: Biểu đồ tròn người dùng --}}
        <div class="col-md-7">
            <div class="card h-100">
                <div class="card-body text-center">
        
                    {{-- Tăng kích thước biểu đồ và để legend dưới --}}
                    <div class="mx-auto" style="max-width: 300px;">
                        <canvas id="userChart"></canvas>
                    </div>
        
                    <p class="mt-3 mb-0 h5">
                        Tổng: {{ $tongGiangVien + $tongNhanVien + $tongAdmin }} người dùng
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Biểu đồ tuyến báo cáo theo ngày --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Biểu đồ số lượng báo cáo theo ngày</h5>
            <canvas id="baoCaoNgayChart" height="100"></canvas>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ tròn số lượng người dùng
    const userCtx = document.getElementById('userChart').getContext('2d');
    new Chart(userCtx, {
        type: 'doughnut',
        data: {
            labels: ['Giảng viên', 'Quản trị viên', 'PĐBCL'],
            datasets: [{
                label: 'Số lượng',
                data: [{{ $tongGiangVien }}, {{ $tongAdmin }}, {{ $tongNhanVien }}],
                backgroundColor: ['#36A2EB', '#4CAF50', '#E91E63'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            aspectRatio: 1, // Giữ hình tròn
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 20,
                        padding: 15,
                        usePointStyle: true // Dùng hình tròn thay vì ô vuông
                    }
                }
            }
        }
    });

    // Biểu đồ tuyến báo cáo theo ngày
    const baoCaoCtx = document.getElementById('baoCaoNgayChart').getContext('2d');
    new Chart(baoCaoCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($baoCaoNgay->toArray())) !!},
            datasets: [{
                label: 'Báo cáo',
                data: {!! json_encode(array_values($baoCaoNgay->toArray())) !!},
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                },
                x: {
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10
                    }
                }
            }
        }
    });
</script>
@endsection

