<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailSetting;
use Illuminate\Support\Facades\Mail;
class EmailSettingController extends Controller
{

    public function index()
{
    $setting = EmailSetting::first(); // luôn chỉ lấy 1 bản ghi duy nhất
    return view('admin.email-settings.index', compact('setting'));
}

public function form()
{
    $setting = EmailSetting::first(); // kiểm tra có chưa
    return view('admin.email-settings.edit', compact('setting'));
}

public function save(Request $request)
{
    $data = $request->validate([
        'username' => 'required|email',
        'password' => 'required',
        'from_address' => 'required|email',
        'from_name' => 'required|string',
    ]);

    $setting = EmailSetting::first();
    if ($setting) {
        $setting->update($data);
        $message = 'Cập nhật cấu hình email thành công!';
    } else {
        EmailSetting::create($data);
        $message = 'Tạo cấu hình email thành công!';
    }

    return redirect()->route('email-settings.index')->with('success', $message);
}


    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        $setting = EmailSetting::first();

        config([
            'mail.mailers.smtp.host' => $setting->host,
            'mail.mailers.smtp.port' => $setting->port,
            'mail.mailers.smtp.encryption' => $setting->encryption,
            'mail.mailers.smtp.username' => $setting->username,
            'mail.mailers.smtp.password' => $setting->password,
            'mail.mailer' => $setting->mailer,
            'mail.from.address' => $setting->from_address,
            'mail.from.name' => $setting->from_name,
        ]);

        try {
            Mail::raw('Thử email thành công!', function ($message) use ($request) {
                $message->to($request->test_email)
                        ->subject('Thử Email hệ thống thành công!');
            });

            return back()->with('success', 'Gửi email kiểm tra thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gửi email thất bại: Email hoặc mật khẩu ứng dụng không chính xác! ' . $e->getMessage());
        }
    }
}
