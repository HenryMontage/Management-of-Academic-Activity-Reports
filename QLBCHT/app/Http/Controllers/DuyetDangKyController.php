<?php
namespace App\Http\Controllers;
use App\Models\DangKyBaoCao;
use Illuminate\Http\Request;
use App\Mail\ThongBaoDuyetDangKy;
use Illuminate\Support\Facades\Mail;

class DuyetDangKyController extends Controller
{
    public function index()
    {
        $dangKyBaoCaos = DangKyBaoCao::where('trangThai', 'Chờ Duyệt')
            ->with(['baoCaos.giangVien', 'lichBaoCao.boMon.khoa'])
            ->get();

        return view('nhanvien.duyet.index', compact('dangKyBaoCaos'));
    }

    public function duyet($maDangKy)
    {
        $dangKy = DangKyBaoCao::findOrFail($maDangKy);
        $dangKy->trangThai = 'Đã Duyệt';
        $dangKy->save();

         // Gửi email cho tất cả giảng viên liên quan
        foreach ($dangKy->baoCaos as $bc) {
            $gv = $bc->giangVien;
            if ($gv->email) {
                Mail::to($gv->email)->queue(new ThongBaoDuyetDangKy($dangKy));
            }
        }

        return redirect()->back()->with('success', 'Đã duyệt đăng ký báo cáo.');
    }

    public function tuChoi($maDangKy)
    {
        $dangKy = DangKyBaoCao::findOrFail($maDangKy);
        $dangKy->trangThai = 'Từ Chối';
        $dangKy->save();

         // Gửi email cho tất cả giảng viên liên quan
         foreach ($dangKy->baoCaos as $bc) {
            $gv = $bc->giangVien;
            if ($gv->email) {
                Mail::to($gv->email)->queue(new ThongBaoDuyetDangKy($dangKy));
            }
        }

        return redirect()->back()->with('success', 'Đã từ chối đăng ký báo cáo.');
    }

    public function daDuyet()
    {
        $dangKyBaoCaos = DangKyBaoCao::where('trangThai', 'Đã Duyệt')
            ->with(['baoCaos.giangVien', 'lichBaoCao.boMon.khoa'])
            ->get();

        return view('nhanvien.duyet.daduyet', compact('dangKyBaoCaos'));
    }

}
