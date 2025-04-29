<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý báo cáo</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary-blue: #005BAA;
            --light-blue: #E3F2FD;
            --hover-blue: #2196F3;
            --text-dark: #2C3E50;
            --bg-light: #F8FAFC;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        /* Navbar Styling */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            padding: 0.8rem 0;
        }

        .navbar-brand {
            color: var(--primary-blue) !important;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .nav-link {
            color: var(--text-dark) !important;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            border-radius: 6px;
            margin: 0 0.2rem;
        }

        .nav-link:hover {
            background-color: var(--light-blue);
            color: var(--primary-blue) !important;
        }

        .nav-link.active {
            background-color: var(--light-blue);
            color: var(--primary-blue) !important;
            font-weight: 500;
        }

        /* Main Content */
        .container.py-4 {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            padding: 2rem !important;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        /* Dropdown Styling */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .dropdown-item {
            padding: 0.7rem 1.5rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: var(--light-blue);
            color: var(--primary-blue);
        }

        /* Footer Styling */
        footer {
            background-color: white !important;
            color: var(--text-dark) !important;
            border-top: 1px solid #E0E7FF;
            padding: 3rem 0 !important;
        }

        footer h5 {
            color: var(--primary-blue);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        footer .list-unstyled a {
            color: var(--text-dark) !important;
            text-decoration: none;
            transition: all 0.3s ease;
            opacity: 0.8;
        }

        footer .list-unstyled a:hover {
            opacity: 1;
            color: var(--primary-blue) !important;
        }

        /* Social Media Buttons */
        footer .social-buttons .btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            background-color: var(--light-blue);
            color: var(--primary-blue);
            border: none;
        }

        footer .social-buttons .btn:hover {
            transform: translateY(-2px);
            background-color: var(--primary-blue);
            color: white;
        }

        /* Back to Top Button */
        .back-to-top {
            background-color: var(--primary-blue);
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            opacity: 0.9;
        }

        .back-to-top:hover {
            opacity: 1;
            transform: translateY(-3px);
            color: white;
        }

        /* Custom Card Styling */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
    </style>

    @yield('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <div class="top-bar bg-primary text-white py-1">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="contact-info d-flex align-items-center">
                    <span class="me-3">
                        <i class="fas fa-phone-alt me-1"></i>
                        Call us : 0258 2461303
                    </span>
                    <span>
                        <i class="fas fa-envelope me-1"></i>
                        E-mail : cntt@ntu.edu.vn
                    </span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .top-bar {
            font-size: 0.9rem;
            background-color: #005BAA !important;
        }
        
        .top-bar .contact-info {
            font-size: 0.85rem;
        }
        
        .form-check-input {
            cursor: pointer;
            width: 35px;
            height: 18px;
        }
        
        .language-selector {
            cursor: pointer;
        }
        
        .language-selector img {
            vertical-align: middle;
        }
    </style>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('user.dashboard') }}">
                <img src="/anhdaidiens/ntu2.png" alt="NTU Logo" height="40" class="me-2">
                <span>NTU Portal</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth('giang_viens')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lichbaocao.index') ? 'active' : '' }}" href="{{ route('lichbaocao.index') }}">
                            <i class="fas fa-calendar-alt me-1"></i> Lịch sinh hoạt học thuật
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('baocao.index') ? 'active' : '' }}" href="{{ route('baocao.index') }}">
                            <i class="fas fa-file-alt me-1"></i> Báo cáo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dangkybaocao.index') ? 'active' : '' }}" href="{{ route('dangkybaocao.index') }}">
                            <i class="fas fa-edit me-1"></i> Đăng ký báo cáo
                        </a>
                    </li>
                   
                    @endauth
                    @auth('nhan_vien_p_d_b_c_ls')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('duyet.index') ? 'active' : '' }}" href="{{ route('duyet.index') }}">
                            <i class="fas fa-check-circle me-1"></i> Duyệt phiếu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('duyet.daduyet') ? 'active' : '' }}" href="{{ route('duyet.daduyet') }}">
                            <i class="fas fa-clipboard-check me-1"></i> Phiếu đã duyệt
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bienban.index') ? 'active' : '' }}" href="{{ route('bienban.index') }}">
                            <i class="fas fa-calendar-alt me-1"></i> Biên bản
                        </a>
                    </li>

                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @php
                        $guard = session('current_guard');
                        $user = Auth::guard($guard)->user();
                    @endphp

                    @if ($user)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <img src="{{ asset('storage/' . ($user->anhDaiDien ?? 'anhDaiDiens/anhmacdinh.jpg')) }}" 
                                         alt="Ảnh đại diện" 
                                          class="rounded-circle me-2"
                                        style="width: 32px; height: 32px; object-fit: cover;"
                                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{  urlencode($user->ho . ' ' . $user->ten) }}&background=0D8ABC&color=fff';">
                            <span>{{ $user->ho }} {{ $user->ten }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user me-2"></i> Trang cá nhân
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        <div class="container py-4">
            @yield('content')
        </div>
    </main>

    <footer class="mt-auto">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-1">
                        <img src="/anhdaidiens/ntu2.png" alt="NTU Logo" class="img-fluid" style="max-height: 50px;">
                        <div class="ms-2">
                            <h5 class="university-name mb-0" style="color: var(--primary-blue); font-size: 1.1rem; font-weight: 700;">TRƯỜNG ĐẠI HỌC NHA TRANG</h5>
                            <div class="system-name" style="color: var(--text-dark); font-size: 0.85rem; opacity: 0.8;">HỆ THỐNG TÍCH HỢP THÔNG TIN</div>
                        </div>
                    </div>
                    <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.4; text-align: justify;">
                        Trải qua hơn 55 năm xây dựng và phát triển, Trường Đại học Nha Trang đã trở thành một trong những cơ sở đào tạo đa ngành, đa lĩnh vực uy tín tại khu vực Nam Trung Bộ, Tây Nguyên và phạm vi cả nước.
                    </p>
                </div>

                <div class="col-md-2">
                    <h5>Thông tin</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="https://ntu.edu.vn">Trường Đại học Nha Trang</a></li>
                        <li class="mb-2"><a href="https://thuvien.ntu.edu.vn/">Thư viện</a></li>
                        <li class="mb-2"><a href="https://tuyensinh.ntu.edu.vn/">Tuyển sinh</a></li>
                        <li class="mb-2"><a href="https://www.coursera.org/">Khóa học mở</a></li>
                    </ul>
                </div>

                <div class="col-md-2">
                    <h5>Liên hệ</h5>
                    <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>02 Nguyễn Đình Chiểu, Nha Trang, Khánh Hòa</p>
                    <p class="mb-2"><i class="fas fa-phone me-2"></i>0258 2461303</p>
                    <p class="mb-2"><i class="fas fa-envelope me-2"></i>cntt@ntu.edu.vn</p>
                </div>

                <div class="col-md-2">
                    <h5>Theo dõi</h5>
                    <div class="social-buttons d-flex gap-2">
                        <a href="#" class="btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn"><i class="fab fa-google"></i></a>
                        <a href="#" class="btn"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center py-2">
            <small style="color: #888888;">Được tạo bởi Kiều Thái Tuấn và Bùi Anh Tú © 2025</small>
        </div>
    </footer>

    <a href="#" class="back-to-top position-fixed bottom-0 end-0 m-3">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.min.js"></script>

    @yield('script')
</body>
</html>
