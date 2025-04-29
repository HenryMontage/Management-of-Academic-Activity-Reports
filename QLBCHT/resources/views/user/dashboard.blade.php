@extends('layouts.user')
@section('page-title', "Trang Chủ")
@section('content')
<div class="container mt-5 text-center">
    <h1 class="display-4">Trang Chủ</h1>
    <p class="lead mt-4">
        Chào mừng bạn đến với phần mềm <strong>Quản lý báo cáo</strong>. 
        Đây là hệ thống hỗ trợ giảng viên và nhân viên trong việc quản lý, tạo lập và theo dõi các báo cáo công việc, học thuật và hành chính.
    </p>

    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📅 Lịch báo cáo</h5>
                    <p class="card-text">Xem lịch báo cáo đã đăng ký và các hạn nộp báo cáo quan trọng.</p>
                    <a href="{{ route('lichbaocao.index') }}" class="btn btn-primary">Xem lịch</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mt-3 mt-md-0">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📄 Quản lý báo cáo</h5>
                    <p class="card-text">Tạo mới, chỉnh sửa hoặc gửi báo cáo trực tuyến.</p>
                    <a href="{{ route('baocao.index') }}" class="btn btn-primary">Xem báo cáo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
