@extends('layouts.app')
@section('page-title', 'Trang Chủ')

@section('content')
<div class="container py-4">

    {{-- Hàng 1 --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Giảng viên</h5>
                    <p class="card-text h4">{{ $tongGiangVien }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Nhân viên PĐBCL</h5>
                    <p class="card-text h4">{{ $tongNhanVien }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Quản trị viên</h5>
                    <p class="card-text h4">{{ $tongAdmin }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Báo cáo</h5>
                    <p class="card-text h4">{{ $tongBaoCao }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Hàng 2 --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Phiếu đăng ký đã duyệt</h5>
                    <p class="card-text h4">{{ $baoCaoDuocDuyet }}/{{ $tongPhieuDangKy }} tổng phiếu</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Báo cáo trong tháng</h5>
                    <p class="card-text h4">{{ $baoCaoTrongThang }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-dark">
                <div class="card-body">
                    <h5 class="card-title">Lịch báo cáo kỳ này</h5>
                    <p class="card-text h4">{{ $baoCaoTrongKy }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Biểu đồ --}}
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
    const ctx = document.getElementById('baoCaoNgayChart').getContext('2d');
    const chart = new Chart(ctx, {
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
                    ticks: {
                        stepSize: 1
                    }
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
