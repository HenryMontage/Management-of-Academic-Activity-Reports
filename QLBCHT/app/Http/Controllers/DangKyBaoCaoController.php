<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\DangKyBaoCao;
use App\Models\GiangVien;
use App\Models\Notification;
use App\Models\BaoCao;
use App\Models\LichBaoCao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ThongBaoDangKyBaoCao;
use App\Mail\BaoCaoKhongDuocChonMail;
use Illuminate\Support\Facades\Mail;

class DangKyBaoCaoController extends Controller
{
    public function index(Request $request)
    {
        $giangVienId = Auth::guard('giang_viens')->user()->maGiangVien;
    
        $baoCaoIds = BaoCao::where('giangVien_id', $giangVienId)->pluck('maBaoCao');
    
        $query = DangKyBaoCao::where('giangVien_id', $giangVienId)
        ->with([
            'baoCaos.giangVien',
            'lichBaoCao.boMon.khoa',
            'lichBaoCao.giangVienPhuTrach.baoCao'
        ]);//->paginate(6);
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('lichBaoCao', function ($subQ) use ($keyword) {
                    $subQ->where('chuDe', 'like', '%' . $keyword . '%');
                })
                ->orWhere('trangThai', 'like', '%' . $keyword . '%')
                ->orWhere('ngayDangKy', 'like', '%' . $keyword . '%');
            });
        }
    
        $dangKyBaoCaos = $query->orderByDesc('ngayDangKy')->paginate(6);
        
    
        return view('dangkybaocao.index', compact('dangKyBaoCaos'));
    }



    // Lấy thông tin chi tiết lịch báo cáo khi chọn
    public function getLichBaoCao($id)
    {
        $lich = LichBaoCao::with(['boMon.khoa', 'giangVienPhuTrach'])->findOrFail($id);
        
        return response()->json([
            'boMon' => $lich->boMon->tenBoMon ?? '',
            'khoa' => $lich->boMon->khoa->tenKhoa ?? '',
            'ngayGio' => $lich->ngayBaoCao . ' ' . $lich->gioBaoCao,
            'diaDiem' => 'VP BM ' . ($lich->boMon->tenBoMon ?? ''),
            'giangViens' => $lich->giangVienPhuTrach->pluck('hoTen'),
            'chuDes' => $lich->giangVienPhuTrach->map(fn($gv) => $gv->baoCaos->pluck('tenBaoCao'))
        ]);
    }


    public function create()
    {
        
        $daDangKyIds = DangKyBaoCao::pluck('lichBaoCao_id')->toArray();
        $giangVienId = Auth::guard('giang_viens')->user()->maGiangVien;
    
        $baoCaos = BaoCao::whereNotNull('lich_bao_cao_id')->get();
    
        $lichBaoCaos = LichBaoCao::with(['boMon.khoa', 'giangVienPhuTrach.baoCao'])->get();

        $giangViens = GiangVien::all();
    
        return view('dangkybaocao.create', compact('baoCaos', 'lichBaoCaos','giangViens', 'daDangKyIds'));
    }
    
    
    public function store(Request $request)
    {
        $guard = session('current_guard');
        $user = Auth::guard($guard)->user();

        $validated = $request->validate([
            'lichBaoCao_id' => 'nullable|exists:lich_bao_caos,maLich',
            // 'baoCao_id' => 'required|exists:bao_caos,maBaoCao',
            'baoCao_ids' => 'required|array',
            'baoCao_ids.*' => 'exists:bao_caos,maBaoCao',
        ]);

           // Kiểm tra nếu lịch báo cáo này đã được đăng ký
        if ($validated['lichBaoCao_id']) {
            $exists = DangKyBaoCao::where('lichBaoCao_id', $validated['lichBaoCao_id'])->exists();

            if ($exists) {
                return redirect()->back()->withInput()->withErrors([
                    'lichBaoCao_id' => 'Chủ đề này đã được đăng ký rồi!',
                ]);
            }
        }

        $dangKy = DangKyBaoCao::create([
            'ngayDangKy' => Carbon::now(),
            'trangThai' => 'Chờ Xác Nhận',
            'lichBaoCao_id' => $validated['lichBaoCao_id'],
            'giangVien_id' => $user->maGiangVien,
        ]);

         Notification::create([
            'loai' => 'phieu_dang_ky',
            'noiDung' => 'Có phiếu đăng ký sinh hoạt học thuật cần xác nhận!',
            'link' => route('duyet.index'),
            'doiTuong' => 'nhan_vien'
        ]);

         // Gắn nhiều báo cáo vào đăng ký
        foreach ($validated['baoCao_ids'] as $baoCaoId) {
            DB::table('bao_cao_dang_ky_bao_caos')->insert([
                'maDangKyBaoCao' => $dangKy->maDangKyBaoCao,
                'maBaoCao' => $baoCaoId,
            ]);
        }
        
        // Gửi email cho tất cả nhân viên
        // $nhanViens = \App\Models\NhanVienPDBCL::all(); // hoặc lọc theo bộ môn/khoa
        // foreach ($nhanViens as $nv) {
        //     Mail::to($nv->email)->queue(new ThongBaoDangKyBaoCao($dangKy));

        // }
        // Tìm các báo cáo không được chọn
        $baoCaosKhongChon = BaoCao::where('lich_bao_cao_id', $validated['lichBaoCao_id'])
        ->whereNotIn('maBaoCao', $validated['baoCao_ids'])
        ->with('giangVien') // Eager load giảng viên
        ->get();

        // foreach ($baoCaosKhongChon as $baoCao) {
        // $gv = $baoCao->giangVien;
        // if ($gv && $gv->email) {
        //     Mail::to($gv->email)->queue(new BaoCaoKhongDuocChonMail($baoCao, $dangKy));
        // }
        // }

        return redirect()->route('dangkybaocao.index')->with('success', 'Đăng ký     thành công');
    }

    public function exportPhieu($maDangKyBaoCao)
    {
        $lich = LichBaoCao::with(['boMon.khoa', 'giangVienPhuTrach.baoCao'])->findOrFail($maDangKyBaoCao);
        $giangVienId = Auth::guard('giang_viens')->user()->maGiangVien;
        $baoCaoIds = BaoCao::where('giangVien_id', $giangVienId)->pluck('maBaoCao');
        $dangKyBaoCaos = DangKyBaoCao::whereHas('baoCaos', function ($query) use ($baoCaoIds) {
            $query->whereIn('bao_caos.maBaoCao', $baoCaoIds);
        })
        ->with([
            'baoCaos.giangVien',
            'lichBaoCao.boMon.khoa',
            'lichBaoCao.giangVienPhuTrach.baoCao'
        ])
        ->get();
        $data = [
            'lich' => $lich,
            'dangKyBaoCaos' => $dangKyBaoCaos
        ];


        $pdf = Pdf::loadView('exports.phieu_dang_ky', $data);
        return $pdf->download('phieu-dang-ky-bao-cao.pdf');
    }
    public function destroy($maDangKyBaoCao)
    {
        $dangKy = DangKyBaoCao::where('maDangKyBaoCao', $maDangKyBaoCao)->firstOrFail(); // thêm firstOrFail()
        if ($dangKy->trangThai !== 'Chờ Xác Nhận') {
            return redirect()->back()->with('error', 'Chỉ có thể xoá đăng ký khi trạng thái là "Chờ Xác Nhận".');
        }
    
        $dangKy->delete();
    
        return redirect()->back()->with('success', 'Xoá đăng ký báo cáo thành công');
    }
    
}
