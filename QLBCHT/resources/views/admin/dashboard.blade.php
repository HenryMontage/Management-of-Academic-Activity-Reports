@extends('layouts.app')
@section('page-title', 'Trang Chủ')

@section('content')
<div class="container-fluid py-4">
    <!-- Thẻ tổng quan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-md-7 bg-primary bg-gradient text-white p-4">
                            <h2 class="display-6 fw-bold mb-3">Tổng quan hệ thống</h2>
                            <p class="lead mb-4">Chào mừng đến với hệ thống quản lý báo cáo học thuật</p>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="display-4 me-3">
                                        <i class="fa-solid fa-calendar-days me-1"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">{{ $tongLichBaoCao }}</h4>
                                        <p class="mb-0 opacity-75">Lịch Sinh Hoạt</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="display-4 me-3">
                                        <i class="fa-solid fa-circle-check me-1"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">{{ $phieuDuocXacNhan }}/{{ $tongPhieuDangKy }}</h4>
                                        <p class="mb-0 opacity-75">Phiếu Đăng Ký Được Xác Nhận</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="display-4 me-3">
                                    <i class="fa-solid fa-clipboard-check me-1"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ $bienBanDuocXacNhan }}/{{ $tongBienBan }}</h4>
                                    <p class="mb-0 opacity-75">Biên Bản Được Xác Nhận</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 p-4">
                            <h3 class="fw-bold mb-4">Tổng {{ $tongGiangVien + $tongNhanVien + $tongAdmin }} người dùng</h3>
                            <div style="height: 250px;">
                                <canvas id="userDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê chính -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <a style="text-decoration: none;color:#000" href="{{ route('giangvien.index') }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Giảng viên</p>
                                <h3 class="fw-bold mb-0">{{ $tongGiangVien }}</h3>
                            </div>
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-chalkboard-teacher text-primary"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($tongGiangVien/($tongGiangVien+$tongNhanVien+$tongAdmin))*100 }}%"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <a style="text-decoration: none;color:#000" href="{{ route('nhanvien.index') }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">PĐBCL</p>
                            <h3 class="fw-bold mb-0">{{ $tongNhanVien }}</h3>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="fas fa-user-tie text-success"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($tongNhanVien/($tongGiangVien+$tongNhanVien+$tongAdmin))*100 }}%"></div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <a style="text-decoration: none;color:#000" href="{{ route('admin.index') }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Quản trị viên</p>
                            <h3 class="fw-bold mb-0">{{ $tongAdmin }}</h3>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="fas fa-user-shield text-warning"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 5px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ ($tongAdmin/($tongGiangVien+$tongNhanVien+$tongAdmin))*100 }}%"></div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Tổng báo cáo</p>
                            <h3 class="fw-bold mb-0">{{ $tongBaoCao }}</h3>
                        </div>
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                            <i class="fas fa-file-alt text-danger"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 5px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ thống kê -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm border-0 p-4">
                <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-3 align-items-end">
                    {{-- <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control" />
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control" />
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-success">Làm mới</a> --}}
                    
                    <div  class="col-4">
                        <label for="from_date" class="form-label">Từ ngày</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                    </div>
                    <div class="col-4">
                        <label for="to_date" class="form-label">Đến ngày</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                    </div>
                    <div class="col-4 d-flex justify-content-start">
                        <button style="margin-right: 10px" type="submit" class="btn btn-success">Tìm</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Làm mới</a>
                    </div>
                  
                </form>
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 mt-3">Biểu đồ số lượng báo cáo theo ngày</h5>
                </div>
                <div style="padding: 0" class="card-body">
                    <canvas id="reportLineChart" height="300"></canvas>
                </div>
            </div>
        </div>
       
    </div>

    <!-- Thống kê chi tiết -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Phân bố báo cáo theo bộ môn</h5>
                </div>
                <div class="card-body">
                    <canvas id="departmentChart" height="290"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Hoạt động gần đây</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach ($notifications as $noti)
                            <div class="list-group-item py-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-{{ $noti['bg'] }} bg-opacity-10 p-2 me-3">
                                        <i class="{{ $noti['icon'] }} text-{{ $noti['bg'] }}"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0">{{ $noti['text'] }}</p>
                                        <small class="text-muted">{{ $noti['time'] }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-opacity-10 {
    --bs-bg-opacity: 0.1;
}

.card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
</style>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ phân bố người dùng (Doughnut chart)
    const userCtx = document.getElementById('userDistributionChart').getContext('2d');
    new Chart(userCtx, {
        type: 'doughnut',
        data: {
            labels: ['Giảng viên', 'PĐBCL', 'Quản trị viên'],
            datasets: [{
                data: [{{ $tongGiangVien }}, {{ $tongNhanVien }}, {{ $tongAdmin }}],
                backgroundColor: [
                    'rgba(13, 110, 253, 0.8)',
                    'rgba(25, 135, 84, 0.8)',
                    'rgba(255, 193, 7, 0.8)'
                ],
                borderColor: [
                    'rgba(13, 110, 253, 1)',
                    'rgba(25, 135, 84, 1)',
                    'rgba(255, 193, 7, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const value = context.raw;
                            const percentage = Math.round((value / total) * 100);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '65%'
        }
    });

    // // Biểu đồ số lượng báo cáo theo thời gian (Line chart)
    @php
        $labels = array_keys($baoCaoNgay->toArray());
        $data = array_values($baoCaoNgay->toArray());
    @endphp
    const reportLineCtx = document.getElementById('reportLineChart').getContext('2d');
    const reportData = @json(array_values($baoCaoTheoThang->toArray()));
   
    const labels = @json($labels); // ngày dạng "2025-05-01"
    const data = @json($data);     // số lượng báo cáo theo ngày

    new Chart(reportLineCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Báo cáo theo ngày',
                data: data,
                borderColor: 'rgba(13, 110, 253, 1)',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });


   // Biểu đồ phân bố báo cáo theo bộ môn (Bar chart)
const deptCtx = document.getElementById('departmentChart').getContext('2d');
const deptLabels = @json($baoCaoTheoBoMon->keys());
const deptData = @json($baoCaoTheoBoMon->values());

new Chart(deptCtx, {
    type: 'bar',
    data: {
        labels: deptLabels,
        datasets: [{
            label: 'Số lượng báo cáo',
            data: deptData,
            backgroundColor: [
                'rgba(13, 110, 253, 0.8)',
                'rgba(25, 135, 84, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(13, 202, 240, 0.8)',
                'rgba(111, 66, 193, 0.8)',
                'rgba(220, 53, 69, 0.8)',
                'rgba(108, 117, 125, 0.8)'
            ],
            borderColor: [
                'rgba(13, 110, 253, 1)',
                'rgba(25, 135, 84, 1)',
                'rgba(255, 193, 7, 1)',
                'rgba(13, 202, 240, 1)',
                'rgba(111, 66, 193, 1)',
                'rgba(220, 53, 69, 1)',
                'rgba(108, 117, 125, 1)'
            ],
            borderWidth: 1,
            barThickness: 70
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});

</script>
@endsection
