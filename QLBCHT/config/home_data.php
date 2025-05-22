<?php

return [

    'features' => [
        [
            'route_name' => 'lichbaocao.index',
            'quyen' => 'lichbaocao',
            'title' => 'Lịch sinh hoạt',
            'desc' => 'Xem thời gian, địa điểm các buổi SHHT',
            'icon' => 'fas fa-calendar-alt',
            'color' => 'primary',
            'step' => 1
        ],
        [
            'route_name' => 'baocao.index',
            'quyen' => 'baocao',
            'title' => 'Quản lý báo cáo',
            'desc' => 'Tạo, chỉnh sửa và theo dõi báo cáo học thuật',
            'icon' => 'fas fa-file-alt',
            'color' => 'success',
            'step' => 2
        ],
        [
            'route_name' => 'dangkybaocao.index',
            'quyen' => 'dangkybaocao',
            'title' => 'Đăng ký sinh hoạt',
            'desc' => 'Đăng ký thời gian và chủ đề báo cáo học thuật',
            'icon' => 'fa-solid fa-file-pen me-1',
            'color' => 'info',
            'step' => 3
        ],
        [
            'route_name' => 'lichbaocaodangky.dangky',
            'quyen' => 'lichbaocaodangky',
            'title' => 'Quản lý đăng ký',
            'desc' => 'Đăng ký hoặc hủy đăng ký tham gia sinh hoạt',
            'icon' => 'fa-solid fa-square-plus',
            'color' => 'info',
            'step' => 3
        ],
        [
            'route_name' => 'duyet.index',
            'quyen' => 'duyet',
            'title' => 'Xác nhận phiếu',
            'desc' => 'Xác nhận phiếu đăng ký sinh hoạt học thuật',
            'icon' => 'fa-solid fa-circle-check me-1',
            'color' => 'success',
            'step' => 2
        ],
        [
            'route_name' => 'xacnhan.index',
            'quyen' => 'xacnhan',
            'title' => 'Xác nhận biên bản',
            'desc' => 'Xác nhận biên bản sinh hoạt học thuật',
            'icon' => 'fa-solid fa-clipboard-check me-1',
            'color' => 'info',
            'step' => 3
        ],
        [
            'route_name' => 'bienban.index',
            'quyen' => 'bienban',
            'title' => 'Quản lý biên bản',
            'desc' => 'Tạo, và theo dõi biên bản học thuật',
            'icon' => 'fa-solid fa-file-signature me-1',
            'color' => 'success',
            'step' => 4
        ],
    ],

    'featuresChucNang' => [
        [
            'route_name' => 'lichbaocao.index',
            'quyen' => 'lichbaocao',
            'title' => 'Lịch sinh hoạt học thuật',
            'desc' => 'Xem lịch sinh hoạt và các hạn nộp báo cáo quan trọng.',
            'icon' => 'fas fa-calendar-alt',
            'color' => 'primary',
            'sub_features' => [
                'Xem lịch sinh hoạt học thuật ',
                'Lọc theo thông tin lịch',
                'Nhận thông báo hạn nộp',
            ],
        ],

        [
            'route_name' => 'baocao.index',
            'quyen' => 'baocao',
            'title' => 'Quản lý báo cáo',
            'desc' => 'Nộp báo cáo học thuật.',
            'icon' => 'fas fa-file-alt',
            'color' => 'success',
            'sub_features' => [
                'Nộp báo cáo mới',
                'Đính kèm tài liệu',
                'Nộp và theo dõi phản hồi',
            ],
        ],

        [
            'route_name' => 'dangkybaocao.index',
            'quyen' => 'dangkybaocao',
            'title' => 'Đăng ký sinh hoạt học thuật',
            'desc' => 'Đăng ký thời gian và chủ đề báo cáo học thuật của bạn.',
            'icon' => 'fas fa-edit',
            'color' => 'info',
            'sub_features' => [
                'Chọn thời gian phù hợp',
                'Đăng ký chủ đề báo cáo',
                'Theo dõi trạng thái',
            ],
        ],
       
        [
            'route_name' => 'bienban.index',
            'quyen' => 'bienban',
            'title' => 'Quản lý biên bản học thuật',
            'desc' => 'Gửi và theo dõi trạng thái biên bản học thuật.',
            'icon' => 'fas fa-file-alt',
            'color' => 'success',
            'sub_features' => [
                'Gửi biên bản',
                'Đính kèm tài liệu',
                'Theo dõi trạng thái biên bản',
            ],
        ],
        [
            'route_name' => 'lichbaocaodangky.dangky',
            'quyen' => 'lichbaocaodangky',
            'title' => 'Đăng ký tham gia sinh hoạt',
            'desc' => 'Đăng ký hoặc hủy đăng ký tham gia sinh hoạt học thuật.',
            'icon' => 'fas fa-file-alt',
            'color' => 'info',
            'sub_features' => [
                'Đăng ký',
                'Hủy đăng ký',
                'Thông báo đến trưởng khoa/bộ môn',
            ],
        ],
        [
            'route_name' => 'duyet.index',
            'quyen' => 'duyet',
            'title' => 'Xác nhận phiếu đăng ký sinh hoạt',
            'desc' => 'Xác nhận hoặc từ chối phiếu đăng ký sinh hoạt học thuật.',
            'icon' => 'fa-solid fa-circle-check me-1',
            'color' => 'success',
            'sub_features' => [
                'Xem danh sách phiếu chờ xác nhận',
                'Xác nhận hoặc từ chối phiếu đăng ký',
                'Thông báo kết quả đến trưởng khoa/bộ môn',
            ],
        ],
        [
            'route_name' => 'xacnhan.index',
            'quyen' => 'xacnhan',
            'title' => 'Xác nhận biên bản sinh hoạt',
            'desc' => 'Xác nhận hoặc từ chối biên bản sinh hoạt học thuật.',
            'icon' => 'fa-solid fa-clipboard-check me-1',
            'color' => 'info',
            'sub_features' => [
                'Xem danh sách biên bản chờ xác nhận',
                'Xác nhận hoặc từ chối biên bản',
                'Thông báo kết quả đến trưởng khoa/bộ môn',
            ],
        ],
    ],
];
