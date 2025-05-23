<?php
namespace App\Http\Controllers;
use App\Models\BienBanBaoCao;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Mail\ThongBaoXacNhanBienBan;
use Illuminate\Support\Facades\Mail;

class XacNhanBienBanController extends Controller
{
    public function index()
    {
        $bienBanBaoCaos = BienBanBaoCao::where('trangThai', 'Chờ Xác Nhận')->paginate(6);
        return view('nhanvien.xacnhanbienban.index', compact('bienBanBaoCaos'));
    }

    public function xacNhan($maBienBan)
    {
        $bienban = BienBanBaoCao::findOrFail($maBienBan);
        $bienban->trangThai = 'Đã Xác Nhận';
        $bienban->save();
         Notification::create([
            'loai' => 'xac_nhan_bien_ban',
            'noiDung' => 'Có biên bản sinh hoạt học thuật đã được xác nhận!',
            'link' => route('bienban.index'),
            'doiTuong' => 'truong_bo_mon'
        ]);
         // Gửi email cho tất cả giảng viên liên quan
        //  $gv = $bienban->giangVien;
        //  if ($gv->email) {
        //      Mail::to($gv->email)->queue(new ThongBaoXacNhanBienBan($bienban));
        //  }

        return redirect()->back()->with('success', 'Đã duyệt đăng ký báo cáo.');
    }

    public function tuChoi($maBienBan)
    {
        $bienban = BienBanBaoCao::findOrFail($maBienBan);
        $bienban->trangThai = 'Từ Chối';
        $bienban->save();
         Notification::create([
            'loai' => 'xac_nhan_bien_ban',
            'noiDung' => 'Có biên bản sinh hoạt học thuật bị từ chối!',
            'link' => route('bienban.index'),
            'doiTuong' => 'truong_bo_mon'
        ]);
         // Gửi email cho tất cả giảng viên liên quan
         $gv = $bienban->giangVien();
         if ($gv->email) {
             Mail::to($gv->email)->queue(new ThongBaoXacNhanBienBan($bienban));
         }

        return redirect()->back()->with('success', 'Đã từ chối đăng ký báo cáo.');
    }

    public function daXacNhan()
    {
        $bienBanBaoCaos = BienBanBaoCao::where('trangThai', 'Đã Xác Nhận')->paginate(6);
        return view('nhanvien.xacnhanbienban.daxacnhan', compact('bienBanBaoCaos'));
    }

}
