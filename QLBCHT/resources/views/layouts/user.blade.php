<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/api/placeholder/32/32">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <x-head.tinymce-config/> --}}
    

    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --dark-bg: #2c3e50;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
        }
        
        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        .nav-link {
            color: var(--dark-bg) !important;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .footer {
            background-color: var(--dark-bg);
            color: white;
            padding: 20px 0;
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .social-icons a {
        font-size: 1.2rem;
        transition: color 0.3s ease;
        }
        .social-icons a:hover {
            color: #007bff !important;
        }
    </style>

    @yield('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('user.dashboard') }}">
                <i class="fas fa-home me-1"></i>
                Trang chủ
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{-- @if(Auth::guard('giang_viens')->check() || Auth::guard('nhan_vien_p_d_b_c_ls')->check()) --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('lichbaocao.index') }}">
                                <i class="fas fa-list-alt me-1"></i>Lịch báo cáo
                            </a>
                        </li>
                    {{-- @endif --}}
                </ul>
                <ul class="navbar-nav">
                    {{-- @if(Auth::guard('giang_viens')->check() || Auth::guard('nhan_vien_p_d_b_c_ls')->check()) --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown">
                                {{-- @if(Auth::guard('giang_viens')->check())
                                    {{ Auth::guard('giang_viens')->user()->ten }}
                                @endif
                                @if(Auth::guard('nhan_vien_p_d_b_c_ls')->check())
                                    {{ Auth::guard('nhan_vien_p_d_b_c_ls')->user()->ten }}
                                @endif --}}
                                Xin chào
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-user me-2"></i>Trang cá nhân
                                </a></li>
                                <li><a class="dropdown-item" href="#"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                </a></li>
                                <form id="logout-form" action="#" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    
                    {{-- @endif --}}
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1" style="min-height: 100vh;">
        @yield('content')
    </main>

    <footer class="bg-light text-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="d-flex align-items-center mb-3">
                        {{-- <img src="/api/placeholder/50/50" alt="Tickies Logo" class="me-3 rounded-circle"> --}}
                        <h4 class="mb-0 fw-bold">Quản Lý Báo Cáo</h4>
                    </div>
                    <p class="text-muted">Chào mừng đến với Phần mềm quản lý  báo cáo, nguồn cung cấp số một của bạn cho mọi thứ liên quan đến báo cáo. Chúng tôi cam kết cung cấp cho bạn trải nghiệm quản lý báo cáo tốt nhất với trọng tâm là độ tin cậy, dịch vụ khách hàng và tính độc đáo.</p>
                </div>
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3">Liên Hệ</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                            Nha Trang, Khánh Hoà, Việt Nam
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone-alt me-2 text-primary"></i>
                            0819530009
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2 text-primary"></i>
                            cooperalansheldon@gmail.com
                        </li>
                    </ul>
                    {{-- <div class="social-icons mt-3">
                        <a href="#" class="text-dark me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-dark me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-dark me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-linkedin-in"></i></a>
                    </div> --}}
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>
                    &copy; {{ date('Y') }} Quản Lý Báo Cáo
                    <span class="mx-2">•</span> 
                    Mọi quyền được bảo lưu
                </p>
                <small class="text-muted">Tạo bởi Anh Tú, Thái Tuấn</small>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.min.js"></script>
    @yield('script')
</body>
</html>