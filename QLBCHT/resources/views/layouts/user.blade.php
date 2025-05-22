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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary-blue: #005BAA;
            --light-blue: #E3F2FD;
            --hover-blue: #2196F3;
            --text-dark: #2C3E50;
            --bg-light: #F8FAFC;
            --bg-color: #ffffff;
            --text-color: #000000;
        }


        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        /* Navbar Styling */
        .navbar {
            background-color: var(--bg-light);
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
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
            background-color: var(--bg-light);
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            /* padding: 1rem !important; */
            margin-top: 2rem;
            margin-bottom: 2rem;
            max-width: 1250px !important;
            padding: 0 !important;
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
            background-color: var(--bg-light) !important;
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

        /* style content */
        .fixed-container {
        max-width: 1250px !important;
        margin: 0;
        padding: 0px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .form-container {
        background-color: var(--bg-light);
        border: 1px solid #ddd;
        border-radius: 4px;
        max-width: 1250px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .form-header {
        background: #005BAA;
        color: white;
        padding: 15px;
        border-radius: 4px 4px 0 0;
        width: 100%;
    }
    .form-body {
        padding: 20px;
        width: 100%;
    }
    .form-section {
        background: #fff;
        border: 1px solid #ddd;
        margin-bottom: 20px;
        padding: 0;
        width: 100%;
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
    .list-group-item {
        border-left: none;
        border-right: none;
        border-radius: 0;
    }
    .list-group-item:first-child {
        border-top: none;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
    .btn-fixed {
        min-width: 120px;
    }
    .btn-hover-danger:hover {
        background-color: #f8d7da; /* đỏ nhạt */
        border-radius: 4px;
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
            <div class="d-flex">
                <div class="d-lg-none">
                    <a class="nav-link dropdown-toggle position-relative notificationDropdown" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i style="font-size: 24px" class="fas fa-bell"></i>
                        <span id="notification-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-3 notification-list" aria-labelledby="notificationDropdown" style="width: 300px; max-height: 400px; overflow-y: auto;">
                        <li>Đang tải...</li>
                    </ul>            
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div style="" class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">

                        @php
                        $guard = session('current_guard');
                        $user = Auth::guard($guard)->user(); 
                        $gv = \App\Models\GiangVien::with('chucVuObj.quyen')->find($user->maGiangVien);

                             $quyen = $current_quyen ?? auth()->user()->quyen ?? auth()->user()->chucVu->quyen ?? null;
                             $dsQuyen =  $user->quyen?->nhomRoute ?? $gv->chucVuObj?->quyen?->nhomRoute ?? [];
                            $menuItems = [
                                'lichbaocao'     => ['<i class="fa-solid fa-calendar-days me-1"></i> Lịch sinh hoạt học thuật', 'lichbaocao.index'],
                                'baocao'         => ['<i class="fa-solid fa-file-lines me-1"></i> Báo cáo', 'baocao.index'],
                                'dangkybaocao'   => ['<i class="fa-solid fa-file-pen me-1"></i> Đăng ký SHHT', 'dangkybaocao.index'],
                                'bienban'        => ['<i class="fa-solid fa-file-signature me-1"></i> Biên bản', 'bienban.index'],
                                'duyet'          => ['<i class="fa-solid fa-circle-check me-1"></i> Xác nhận phiếu', 'duyet.index'],
                                'xacnhan'        => ['<i class="fa-solid fa-clipboard-check me-1"></i> Xác nhận biên bản', 'xacnhan.index'],
                                'lichbaocaodangky' => ['<i class="fa-solid fa-square-plus"></i> Đăng ký tham gia SHHT', 'lichbaocaodangky.dangky'],
                                'giangvien' => ['<i class="fa-solid fa-person-chalkboard me-1"></i> Giảng viên', 'giangvien.dsgv'],
                            ];
                        @endphp

                        @foreach ($menuItems as $key => [$label, $route])
                            @if(in_array($key, $dsQuyen))

                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs($route) ? 'active' : '' }}" href="{{ route($route) }}">
                                        {!! $label !!}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                
                </ul>
                <ul class="navbar-nav">

                    @if ($user)
                       <li class="nav-item dropdown d-flex align-items-center">
                           
                             <div class="d-none d-lg-block">
                                <!-- Icon thông báo -->
                                 <a class="nav-link dropdown-toggle position-relative notificationDropdown" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i style="font-size: 20px" class="fas fa-bell"></i>
                                <span id="notification-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-3 notification-list" aria-labelledby="notificationDropdown" style="width: 300px; max-height: 400px; overflow-y: auto;" >
                                <li>Đang tải...</li>
                            </ul>
                                
                            </div>
                        </li>


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
            <div class="d-flex row justify-content-between">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-1">
                        <img src="/anhdaidiens/ntu2.png" alt="NTU Logo" class="img-fluid" style="max-height: 50px;">
                        <div class="ms-2">
                            <h5 class="university-name mb-0" style="color: var(--primary-blue); font-size: 1.1rem; font-weight: 700;">TRƯỜNG ĐẠI HỌC NHA TRANG</h5>
                            <div class="system-name" style="color: var(--text-dark); font-size: 0.85rem; opacity: 0.8;">HỆ THỐNG QUẢN LÝ BÁO CÁO HỌC THUẬT</div>
                        </div>
                    </div>
                    <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.4; text-align: justify;">
                        Hệ thống quản lý báo cáo học thuật giúp giảng viên và nhân viên dễ dàng đăng ký, theo dõi và quản lý các báo cáo học thuật tại Trường Đại học Nha Trang.
                    </p>
                </div>

                <div class="col-md-2">
                    <h5>Liên kết</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="https://ntu.edu.vn" target="_blank">Trang chủ NTU</a></li>
                        <li class="mb-2"><a href="https://thuvien.ntu.edu.vn/" target="_blank">Thư viện</a></li>
                        <li class="mb-2"><a href="https://daotao.ntu.edu.vn/" target="_blank">Đào tạo</a></li>
                        <li class="mb-2"><a href="https://tuyensinh.ntu.edu.vn/" target="_blank">Tuyển sinh</a></li>
                    </ul>
                </div>

                <div class="col-md-2">
                    <h5>Hỗ trợ</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Hướng dẫn sử dụng</a></li>
                        <li class="mb-2"><a href="#">Câu hỏi thường gặp</a></li>
                        <li class="mb-2"><a href="#">Quy định báo cáo</a></li>
                        <li class="mb-2"><a href="#">Liên hệ hỗ trợ</a></li>
                    </ul>
                </div>

                <div class="col-md-3">
                    <h5>Thông tin liên hệ</h5>
                    <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-map-marker-alt me-2"></i>02 Nguyễn Đình Chiểu, Nha Trang, Khánh Hòa</p>
                    <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-phone me-2"></i>0258 2461303</p>
                    <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-envelope me-2"></i>cntt@ntu.edu.vn</p>
                    <div class="social-buttons d-flex gap-2 mt-3">
                        <a href="https://www.facebook.com/daihocnhatrang" target="_blank" class="btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.youtube.com/c/TrườngĐạihọcNhaTrang" target="_blank" class="btn" title="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="mailto:cntt@ntu.edu.vn" class="btn" title="Email"><i class="fas fa-envelope"></i></a>
                        <a href="https://ntu.edu.vn" target="_blank" class="btn" title="Website"><i class="fas fa-globe"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center py-3 mt-4" style="background-color: rgba(0,0,0,0.03);">
            <p class="mb-0" style="font-size: 0.85rem; color: #6c757d;">
                © 2024 Trường Đại học Nha Trang. Phát triển bởi Kiều Thái Tuấn và Bùi Anh Tú.
            </p>
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

<script>
    $(document).ready(function () {
        const loadNotifications = () => {
            $.get("{{ route('notifications.index') }}", function (data) {
                let html = '';
                if (data.length > 0) {
                    data.forEach(function (item) {
                        const textClass = item.daDoc ? 'text-muted' : 'fw-bold';
                       html += `<li  style="border-bottom: 1px solid #dee2e6;">
                            <div class="d-flex justify-content-between align-items-start align-items-center">
                                <a href="${item.link}" class="dropdown-item ${textClass} flex-grow-1 text-wrap" style="white-space: normal;">${item.noiDung}</a>
                                <button style="font-size:25px;" class="btn btn-sm btn-link text-danger btn-delete-notification px-1 btn-hover-danger" data-id="${item.id}" title="Xóa"><i class="fas fa-times"></i></button>
                            </div>
                        </li>`;
                    });
                } else {
                    html = '<li class="text-muted">Không có thông báo</li>';
                }
                $('.notification-list').html(html);

                // Gửi request đánh dấu đã đọc
                $.post("{{ route('notifications.read') }}", {
                    _token: "{{ csrf_token() }}"
                });

                // Ẩn số lượng
                $('#notification-count').text('');
            });
        };

        // Khi ấn chuông => load danh sách
        $('.notificationDropdown').on('click', function () {
            loadNotifications();
        });

        // Khi trang load => hiện số lượng chưa đọc
        $.get("{{ route('notifications.index') }}", function (data) {
            const unreadCount = data.filter(item => item.daDoc == false).length;
            if (unreadCount > 0) {
                $('#notification-count').text(unreadCount);
            }
        });

        // Khi click vào nút xóa thông báo
        $(document).on('click', '.btn-delete-notification', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            const $item = $(this).closest('li');

            $.ajax({
                url: "{{ route('notifications.delete') }}",
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function () {
                    $item.remove();
                }
            });
        });
    });
</script>



</body>
</html>
