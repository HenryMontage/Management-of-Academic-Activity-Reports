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
        $dangKyBaoCaos = DangKyBaoCao::where('trangThai', 'Chờ Xác Nhận')
            ->with(['baoCaos.giangVien', 'lichBaoCao.boMon.khoa'])
            ->paginate(6);

        return view('nhanvien.duyet.index', compact('dangKyBaoCaos'));
    }

    public function duyet($maDangKy)
    {
        $dangKy = DangKyBaoCao::findOrFail($maDangKy);
        $dangKy->trangThai = 'Đã Xác Nhận';
        $dangKy->save();

         // Gửi email 
         $lich = $dangKy->lichBaoCao;
         $gv = $lich->giangVien;
         if ($gv->email) {
            Mail::to($gv->email)->queue(new ThongBaoDuyetDangKy($dangKy));
        }
        // foreach ($dangKy->lichBaoCao as $lich) {
        //     $gv = $lich->giangVien;
        //     if ($gv->email) {
        //         Mail::to($gv->email)->queue(new ThongBaoDuyetDangKy($dangKy));
        //     }
        // }

        return redirect()->back()->with('success', 'Đã xác nhận phiếu đăng ký sinh hoạt học thuật!');
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

        return redirect()->back()->with('success', 'Đã từ chối phiếu đăng ký sinh hoạt học thuật!');
    }

    public function daDuyet()
    {
        $dangKyBaoCaos = DangKyBaoCao::where('trangThai', 'Đã Xác Nhận')
            ->with(['baoCaos.giangVien', 'lichBaoCao.boMon.khoa'])
            ->paginate(6);

        return view('nhanvien.duyet.daduyet', compact('dangKyBaoCaos'));
    }

}
