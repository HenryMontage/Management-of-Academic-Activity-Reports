
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Admin Panel') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
    {{-- html editer --}}
    {{-- <x-head.tinymce-config/> --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #005BAA; /* Màu xanh đặc trưng của NTU */
            --secondary-color: #0056b3;
            --text-color: #2b2d42;
            --background-color: #f8f9fa;
            --sidebar-width: 240px;
            --box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        body {
            background-color: var(--background-color);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Improved Responsive Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            transition: transform 0.3s ease-in-out;
            z-index: 1040;
            overflow-y: auto;
            box-shadow: var(--box-shadow);
        }

        /* Style content */
        .fixed-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }
    .form-container {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .form-header {
        background: #198754;
        color: white;
        padding: 15px;
        border-radius: 4px 4px 0 0;
    }
    .form-body {
        padding: 20px;
    }
    .form-section {
        background: #fff;
        border: 1px solid #ddd;
        margin-bottom: 20px;
    }
    .section-header {
        background: #f8f9fa;
        padding: 10px 15px;
        border-bottom: 1px solid #ddd;
    }
    .section-body {
        padding: 15px;
    }
    .input-group {
        margin-bottom: 10px;
    }
    .btn-fixed {
        min-width: 120px;
    }

        /* Mobile Styles */
        @media (max-width: 992px) {
            .sidebar {
                width: 300px;
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                width: 100%;
                margin-left: 0;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1030;
            }

            .overlay.show {
                display: block;
            }
        }

        /* Desktop Styles */
        @media (min-width: 993px) {
            .main-content {
                margin-left: var(--sidebar-width);
                width: calc(100% - var(--sidebar-width));
            }
        }

        .sidebar-brand {
            padding: 1rem;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.1);
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: bold;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .sidebar-brand:hover {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .sidebar-menu .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            transform: translateX(5px);
        }

        .topbar {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 25px;
            position: sticky;
            top: 0;
            z-index: 1020;
            border-radius: 0 0 15px 15px;
        }

        .content-wrapper {
            padding: 25px;
        }

        /* User Dropdown */
        .user-actions .dropdown-toggle {
            display: flex;
            align-items: center;
            color: var(--text-color);
            font-weight: 500;
            text-decoration: none;
        }

        .user-actions .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
            padding: 0.5rem;
        }

        .user-actions .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            transition: all 0.2s ease;
        }

        .user-actions .dropdown-item:hover {
            background-color: rgba(0, 91, 170, 0.1);
        }

        .user-actions .dropdown-item.text-danger:hover {
            background-color: rgba(220, 53, 69, 0.1);
        }

        /* Page title styling */
        .page-title {
            background-color: var(--primary-color);
            color: white;
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 91, 170, 0.2);
        }
    </style>
</head>
<body>
    <!-- Overlay for mobile sidebar -->
    <div class="overlay"></div>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <nav class="col sidebar" id="sidebar">
                <div class="sidebar-brand">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center justify-content-center text-decoration-none px-3">
                        <img src="{{ asset('anhdaidiens/ntu1.jpg') }}" alt="Logo NTU" style="height: 45px; width: 45px; border-radius: 50%; margin-right: 10px; border: 2px solid white;">
                        <span class="text-white" style="font-size: 18px; font-weight: 600;">Quản trị viên</span>
                    </a>
                </div>
                <div class="sidebar-menu mx-3 mt-4">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} text-white rounded" style="font-size: 16px;">
                                <i class="fa-solid fa-house"></i> Trang chủ
                            </a>
                        </li>
                        @php
                            $quyen = auth()->user()->quyen ?? auth()->user()->chucVu->quyen ?? null;
                            $dsQuyen = $quyen?->nhomRoute ?? [];
                            $menuItems = [
                                'admin'     => ['<i class="fa-solid fa-user-shield me-1"></i> Quản trị viên', 'admin.index'],
                                'giangvien' => ['<i class="fa-solid fa-person-chalkboard me-1"></i> Giảng viên', 'giangvien.index'],
                                'nhanvien'  => ['<i class="fa-solid fa-user-tie me-1"></i> PĐBCL', 'nhanvien.index'],
                                'khoa'      => ['<i class="fa-solid fa-building-columns me-1"></i> Khoa', 'khoa.index'],
                                'bomon'     => ['<i class="fa-solid fa-book-open-reader me-1"></i> Bộ môn', 'bomon.index'],
                                'chucvu'    => ['<i class="fa-solid fa-id-badge me-1"></i> Chức vụ', 'chucvu.index'],
                                'quyen'     => ['<i class="fa-solid fa-user-lock me-1"></i> Phân quyền', 'quyen.index'],
                                'email'     => ['<i class="fa-solid fa-envelope me-1"></i> Email', 'email-settings.index'],
                            ];
                        @endphp

                        @foreach ($menuItems as $key => [$label, $route])
                            @if(in_array($key, $dsQuyen))
                                <li class="nav-item">
                                    <a href="{{ route($route) }}" class="nav-link {{ request()->routeIs($route) ? 'active' : '' }} text-white rounded" style="font-size: 16px;">
                                        {!! $label !!}
                                    </a>
                                </li>
                               
                            @endif
                        @endforeach
                    </ul>
                    </ul>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="main-content">
                <!-- Top Bar -->
                <div class="topbar d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-light me-3 d-md-none toggle-sidebar" type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <h1 class="h5 m-0 page-title">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    
                    <div class="user-actions">
                        @php
                            $guard = session('current_guard');
                            $user = Auth::guard($guard)->user();
                        @endphp
                        @if ($user)
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle d-flex align-items-center" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2" style="width: 40px; height: 40px; background-color: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <span>{{ $user->ho }} {{ $user->ten }}</span>
                                            <small class="d-block text-muted">{{ ucfirst($guard) }}</small>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#">
                                        <i class="fas fa-user me-2"></i> Cá nhân
                                    </a></li>
                                    <li><a class="dropdown-item" href="#">
                                        <i class="fas fa-cog me-2"></i> Cài đặt
                                    </a></li>
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
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Page Content -->
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="#" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.overlay');
            const toggleButtons = document.querySelectorAll('.toggle-sidebar');
            
            // Highlight active menu item
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar-menu .nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.includes(href.split('?')[0])) {
                    link.classList.add('active');
                }
                
                // Sidebar Toggle
                link.addEventListener('click', function() {
                    if (window.innerWidth < 993) {
                        sidebar.classList.remove('show');
                        overlay.classList.remove('show');
                    }
                });
            });

            // Toggle sidebar
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                });
            });

            // Close sidebar when clicking overlay
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });

            // Prevent zoom on input focus (mobile)
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    document.querySelector('meta[name=viewport]').setAttribute(
                        'content', 
                        'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'
                    );
                });
            });
            
            // Add smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    if (href !== "#") {
                        e.preventDefault();
                        document.querySelector(href).scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
    @yield('script')
</body>
</html>









