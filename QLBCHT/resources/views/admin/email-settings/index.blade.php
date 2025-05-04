@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Cấu hình Email hiện tại</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Email SMTP</th>
            <td>{{ $setting->username ?? 'Chưa cấu hình' }}</td>
        </tr>
        <tr>
            <th>Địa chỉ gửi</th>
            <td>{{ $setting->from_address ?? 'Chưa cấu hình' }}</td>
        </tr>
        <tr>
            <th>Tên người gửi</th>
            <td>{{ $setting->from_name ?? 'Chưa cấu hình' }}</td>
        </tr>
    </table>

    <a href="{{ route('email-settings.form') }}" class="btn btn-warning">Cấu hình Email</a>

    <hr>
    <h4>Gửi Email Kiểm Tra</h4>
    <form action="{{ route('email-settings.test') }}" method="POST" class="row g-3">
        @csrf
        <div class="col-auto">
            <input style="width:325px" type="email" name="test_email" class="form-control" placeholder="Nhập email nhận thử" required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Gửi thử</button>
        </div>
    </form>
</div>
@endsection
