<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\DangKyBaoCao;
use App\Models\GiangVien;
use App\Models\BaoCao;
use App\Models\LichBaoCao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ThongBaoDangKyBaoCao;
use Illuminate\Support\Facades\Mail;

class DangKyBaoCaoController extends Controller
{
    public function index()
    {
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
        ->paginate(6);
    
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
        $giangVienId = Auth::guard('giang_viens')->user()->maGiangVien;
    
        $baoCaos = BaoCao::whereNotNull('lich_bao_cao_id')->get();
    
        $lichBaoCaos = LichBaoCao::with(['boMon.khoa', 'giangVienPhuTrach.baoCao'])->get();

        $giangViens = GiangVien::all();
    
        return view('dangkybaocao.create', compact('baoCaos', 'lichBaoCaos','giangViens'));
    }
    
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lichBaoCao_id' => 'nullable|exists:lich_bao_caos,maLich',
            // 'baoCao_id' => 'required|exists:bao_caos,maBaoCao',
            'baoCao_ids' => 'required|array',
            'baoCao_ids.*' => 'exists:bao_caos,maBaoCao',
        ]);

        // $dangKy = DangKyBaoCao::create([
        //     'ngayDangKy' => Carbon::now(),
        //     'trangThai' => 'Chờ Duyệt',
        //     'lichBaoCao_id' => $validated['lichBaoCao_id'],
        //     'baoCao_id' => $validated['baoCao_id'],
        // ]);
        $dangKy = DangKyBaoCao::create([
            'ngayDangKy' => Carbon::now(),
            'trangThai' => 'Chờ Duyệt',
            'lichBaoCao_id' => $validated['lichBaoCao_id'],
        ]);

         // Gắn nhiều báo cáo vào đăng ký
        foreach ($validated['baoCao_ids'] as $baoCaoId) {
            DB::table('bao_cao_dang_ky_bao_caos')->insert([
                'maDangKyBaoCao' => $dangKy->maDangKyBaoCao,
                'maBaoCao' => $baoCaoId,
            ]);
        }
        
        // Gửi email cho tất cả nhân viên
        $nhanViens = \App\Models\NhanVienPDBCL::all(); // hoặc lọc theo bộ môn/khoa
        foreach ($nhanViens as $nv) {
            Mail::to($nv->email)->queue(new ThongBaoDangKyBaoCao($dangKy));

        }

        return redirect()->route('dangkybaocao.index')->with('success', 'Đăng ký báo cáo thành công');
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
        $dangKy = DangKyBaoCao::findOrFail($maDangKyBaoCao);
    
        if ($dangKy->trangThai !== 'Chờ Duyệt') {
            return redirect()->back()->with('error', 'Chỉ có thể xoá đăng ký khi trạng thái là "Chờ Duyệt".');
        }
    
        $dangKy->delete();
    
        return redirect()->back()->with('success', 'Xoá đăng ký báo cáo thành công');
    }
    
}
