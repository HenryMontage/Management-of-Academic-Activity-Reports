{{-- <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap CSS -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

    <style>
        .fs{
            font-size: 16px;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">

        <!-- Sidebar -->
        <aside style="background-color: #2b2a2a" class="bg-dark text-white d-flex flex-column" style="width: 260px; height: 100vh;">
            <!-- Tiêu đề -->
            <div style="padding: 10px" class="d-flex align-items-center justify-content-center bg-secondary py-3">
                <h5 style="font-size: 20px; margin-top:6px;" class=" text-center">Quản lý hệ thống</h5>
            </div>
        
            <!-- Menu -->
            <nav class="flex-grow-1 px-3 pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white bg-secondary p-3 rounded" style="font-size: 16px;">
                            🏠 Trang chủ
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.index') }}" class="nav-link text-white p-3 rounded" style="font-size: 16px;">
                            👤 Quản trị viên
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('giangvien.index') }}" class="nav-link text-white p-3 rounded" style="font-size: 16px;">
                            📚 Giảng viên
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-white p-3 rounded" style="font-size: 16px;">
                            👨‍💼 Nhân viên
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('khoa.index') }}" class="nav-link text-white p-3 rounded" style="font-size: 16px;">
                            🏢 Khoa
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('bomon.index') }}" class="nav-link text-white p-3 rounded" style="font-size: 16px;">
                            📖 Bộ môn
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('chucvu.index') }}" class="nav-link text-white p-3 rounded" style="font-size: 16px;">
                            📖 Chức vụ
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        

        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            
            <!-- Header -->
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <span class="text-lg font-semibold" style="font-size: 20px">Trang quản trị</span>
                <div class="flex items-center">
                    <span class="mr-4">👋 Xin chào, {{ Auth::user()->name ?? 'Admin' }}</span>
                    <form method="POST" action="">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">🚪 Đăng xuất</button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>
     <!-- jQuery -->
     <script src="//code.jquery.com/jquery.js"></script>
     <!-- DataTables -->
     <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
     <!-- Bootstrap JavaScript -->
     <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    @yield('script')
</body>
</html> --}}



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
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --sidebar-width: 220px;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
        }

        /* Improved Responsive Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background-color: #2c3034;
            transition: transform 0.3s ease-in-out;
            z-index: 1040;
            overflow-y: auto;
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
            padding: 0.8rem;
            text-align: center;
            background-color: #212529;
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: bold;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            transition: text-shadow 0.3s ease;
        }

        .sidebar-brand:hover {
            text-shadow: 0 0 20px rgba(255, 255, 255, 1);
        }

        .sidebar-menu .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            background-color: rgba(185, 177, 177, 0.3);
            color: #ffffff;
        }

        .topbar {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .content-wrapper {
            padding: 20px;
        }

        /* Improved Responsive Handling */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Prevent input zoom on mobile */
        @media (max-width: 576px) {
            input, select, textarea {
                font-size: 16px;
            }
        }

        /* User Dropdown */
        .user-actions .dropdown-toggle {
            display: flex;
            align-items: center;
        }

        /* Smooth Transitions */
        * {
            transition: all 0.3s ease;
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
                    Admin Panel
                </div>
                <div class="sidebar-menu mx-2">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white p-3 rounded" style="font-size: 16px;">
                                🏠 Trang chủ
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.index') }}" class="nav-link text-white p-3 rounded" style="font-size: 16px;">
                                👤 Quản trị viên
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('giangvien.index') }}" class="nav-link text-white p-3 rounded" style="font-size: 16px;">
                                📚 Giảng viên
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link text-white p-3 rounded" style="font-size: 16px;">
                                👨‍💼 Nhân viên
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('khoa.index') }}" class="nav-link text-white p-3 rounded" style="font-size: 16px;">
                                🏢 Khoa
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('bomon.index') }}" class="nav-link text-white p-3 rounded" style="font-size: 16px;">
                                📖 Bộ môn
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('chucvu.index') }}" class="nav-link text-white p-3 rounded" style="font-size: 16px;">
                                📖 Chức vụ
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="main-content">
                <!-- Top Bar -->
                <div class="topbar d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-secondary me-3 d-md-none toggle-sidebar" type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <h1 class="h5 m-0 p-2" style="background-color: #4A90E2; color: white; border-radius: 0.25rem;">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    
                    <div class="user-actions">
                        
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle text-decoration-none" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-2"></i>
                                    {{-- <span>{{ $currentUser->name }}</span> --}}
                                    Xin chào Quản trị viên
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#">
                                        <i class="fas fa-user me-2"></i> Cá nhân
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        
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

            // Sidebar Toggle
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

            // Close sidebar on nav link click (mobile)
            const navLinks = document.querySelectorAll('.sidebar-menu .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 993) {
                        sidebar.classList.remove('show');
                        overlay.classList.remove('show');
                    }
                });
            });

            // Prevent zoom on input focus (mobile)
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    if (window.innerWidth < 576) {
                        document.querySelector('meta[name=viewport]').setAttribute(
                            'content', 
                            'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'
                        );
                    }
                });
                input.addEventListener('blur', function() {
                    document.querySelector('meta[name=viewport]').setAttribute(
                        'content', 
                        'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'
                    );
                });
            });
        });
    </script>
    @yield('script')
</body>
</html>
