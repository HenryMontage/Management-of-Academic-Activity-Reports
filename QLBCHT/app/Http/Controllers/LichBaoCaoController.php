<?php

namespace App\Http\Controllers;

use App\Models\LichBaoCao;
use App\Models\BaoCao;
use App\Models\GiangVien;
use App\Models\Notification;
use App\Models\BoMon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\LichBaoCaoRequest;
use App\Mail\ThongBaoLichBaoCao;
use App\Mail\DangKySHHTMail;
use App\Mail\HuyDangKySHHTMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class LichBaoCaoController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
    
        $query = LichBaoCao::with(['boMon', 'giangVienPhuTrach','baoCaos.giangVien']);


        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('chuDe', 'like', '%' . $keyword . '%')
                  ->orWhere('ngayBaoCao', 'like', '%' . $keyword . '%')
                  ->orWhere('gioBaoCao', 'like', '%' . $keyword . '%')
                  ->orWhere('hanNgayNop', 'like', '%' . $keyword . '%')
                  ->orWhere('hanGioNop', 'like', '%' . $keyword . '%')
                  ->orWhereHas('boMon', function ($subQ) use ($keyword) {
                      $subQ->where('tenBoMon', 'like', '%' . $keyword . '%');
                  });
                //   ->orWhereHas('giangVienPhuTrach', function ($subQ) use ($keyword) {
                //       $subQ->where('ho', 'like', '%' . $keyword . '%')
                //            ->orWhere('ten', 'like', '%' . $keyword . '%');
                //   });
            });
             // Tìm giảng viên phụ trách (separate condition)
             $query->orWhereHas('giangVienPhuTrach', function ($subQ) use ($keyword) {
                $subQ->whereRaw("CONCAT(ho, ' ', ten) LIKE ?", ['%' . $keyword . '%']);
            });
            
            
        }
    
        $dsLichBaoCao = $query->orderByDesc('ngayBaoCao')->paginate(6);
    
        return view('lichbaocao.index', compact('dsLichBaoCao', 'keyword'));
    }
    

public function getBaoCaoTheoLich($maLich)
{
    $baoCaos = BaoCao::where('lich_bao_cao_id', $maLich)
        ->with('giangVien')
        ->get()
        ->map(function ($bc) {
            return [
                'tenBaoCao' => $bc->tenBaoCao,
                'giangVien' => $bc->giangVien->ho . ' ' . $bc->giangVien->ten,
                'duongDanFile' => asset($bc->duongDanFile), // nếu lưu trong storage
            ];
        });

    return response()->json($baoCaos);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $giangViens = GiangVien::all();
        $guard = session('current_guard');
        $user = Auth::guard($guard)->user();
        $maGv = $user->maGiangVien;
        $boMons = BoMon::all();
        return view('lichbaocao.create', compact('giangViens', 'boMons','maGv'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LichBaoCaoRequest $request)
    {

        $guard = session('current_guard');
        $user = Auth::guard($guard)->user();
        $maGv = $user->maGiangVien;
        $data = $request->validated();
        $lichBaoCao = LichBaoCao::create([
            'ngayBaoCao' => $data['ngayBaoCao'],
            'gioBaoCao' => $data['gioBaoCao'],
            'chuDe' => $data['chuDe'],
            'giangVienPhuTrach_id' => $maGv,
            'hanNgayNop' => $data['hanNgayNop'],
            'hanGioNop' => $data['hanGioNop'],
            'boMon_id' => $data['boMon_id'],        
        ]);
        // Gán nhiều giảng viên vào lịch báo cáo
        $lichBaoCao->giangVienPhuTrach()->sync($request->giangVienPhuTrach);
        
        Notification::create([
            'loai' => 'lich',
            'noiDung' => 'Có lịch sinh hoạt học thuật mới!',
            'link' => route('lichbaocao.index'),
            'doiTuong' => 'giang_vien'
        ]);
        Notification::create([
            'loai' => 'lich',
            'noiDung' => 'Có lịch sinh hoạt học thuật mới!',
            'link' => route('lichbaocao.index'),
            'doiTuong' => 'nhan_vien'
        ]);


        // foreach ($lichBaoCao->giangVienPhuTrach as $gv) {
        //     Mail::to($gv->email)->queue(new ThongBaoLichBaoCao($lichBaoCao));
        // }
        
        return redirect()->route('lichbaocao.index')->with('success', 'Lịch báo cáo được tạo thành công.');
    }


    /**
     * Display the specified resource.
     */
    public function show(LichBaoCao $lichBaoCao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($maLich)
    {
        $lich = LichBaoCao::with('giangVienPhuTrach')->where('maLich', $maLich)->firstOrFail();
        $giangViens = GiangVien::where('boMon_id', $lich->boMon_id)->get();
        $boMons = BoMon::all();
    
        return view('lichbaocao.edit', compact('lich', 'giangViens', 'boMons'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(LichBaoCaoRequest $request, $maLich)
    {
      
    
        $lich = LichBaoCao::where('maLich', $maLich)->firstOrFail();

        $lich->update($request->validated());
        $lich->giangVienPhuTrach()->sync($request->giangVienPhuTrach ?? []);
        return redirect()->route('lichbaocao.index')->with('success', 'Lịch báo cáo đã được cập nhật.');
    }
    
    // API lấy danh sách giảng viên theo bộ môn (Dùng AJAX)
    public function getGiangVien($boMon_id)
{
    $giangViens = GiangVien::where('boMon_id', $boMon_id)->get();

    if ($giangViens->isEmpty()) {
        return response()->json(['message' => 'Không có giảng viên nào'], 404);
    }

    return response()->json($giangViens);
}
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($maLich)
    {
        $lich = LichBaoCao::withCount('dangKyBaoCaos')->findOrFail($maLich);
    
        // Nếu có ít nhất 1 đăng ký báo cáo thì không cho xóa
        if ($lich->dang_ky_bao_caos_count > 0) {
            return redirect()->route('lichbaocao.index')
                ->with('error', 'Không thể xóa lịch vì đã đăng ký tổ chức sinh hoạt học thuật cho lịch này rồi!');
        }
    
        $lich->delete();
    
        return redirect()->route('lichbaocao.index')
            ->with('success', 'Lịch báo cáo đã được xóa.');
    }
    
    
public function dangKyView()
{
    // $lichBaoCaos = LichBaoCao::with('boMon', 'giangVienPhuTrach')->get();
    $giangVien = Auth::guard('giang_viens')->user();

    // Lấy các lịch báo cáo mà giảng viên đã đăng ký
    $lichDaDangKy = DB::table('lich_bao_cao_giang_vien')
                        ->where('giang_vien_id', $giangVien->maGiangVien)
                        ->pluck('lich_bao_cao_id')->toArray();
    
    // Lấy lịch báo cáo có ngày báo cáo < ngày hiện tại trừ 3 ngày
    $lichBaoCaos = LichBaoCao::with('boMon', 'giangVienPhuTrach')
                            ->where('ngayBaoCao', '>', Carbon::now()->addDays(4)) // Ngày báo cáo phải lớn hơn 10 ngày sau hôm nay
                            ->paginate(6);

    return view('lichbaocaodangky.dangky', compact('lichBaoCaos', 'lichDaDangKy'));
}

public function dangKySubmit(Request $request)
{
    $request->validate([
        'lich_bao_cao_id' => 'required|exists:lich_bao_caos,maLich',
    ]);

    $giangVienDangKy = Auth::guard('giang_viens')->user();

    // Kiểm tra xem giảng viên đã đăng ký lịch này chưa
    $daDangKy = DB::table('lich_bao_cao_giang_vien')
        ->where('lich_bao_cao_id', $request->lich_bao_cao_id)
        ->where('giang_vien_id', $giangVienDangKy->maGiangVien)
        ->exists();

    if ($daDangKy) {
        return redirect()->back()->with('error', 'Bạn đã đăng ký lịch này rồi.');
    }

    // Thêm bản ghi vào bảng pivot
    DB::table('lich_bao_cao_giang_vien')->insert([
        'lich_bao_cao_id' => $request->lich_bao_cao_id,
        'giang_vien_id' => $giangVienDangKy->maGiangVien,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Gửi email cho giảng viên lên lịch
    $lichBaoCao = LichBaoCao::with(['giangVien', 'boMon.khoa'])->findOrFail($request->lich_bao_cao_id);
    $giangVienLenLich = $lichBaoCao->giangVien;

    if ($giangVienLenLich && $giangVienLenLich->email) {
        Mail::to($giangVienLenLich->email)->queue(new DangKySHHTMail($lichBaoCao, $giangVienDangKy));
    }


    return redirect()->back()->with('success', 'Đăng ký lịch thành công.');
}

public function huyDangKy(Request $request)
{
    $request->validate([
        'lich_bao_cao_id' => 'required|exists:lich_bao_caos,maLich',
    ]);

    $giangVienHuyDangKy = Auth::guard('giang_viens')->user();

    // Kiểm tra xem giảng viên đã đăng ký lịch này chưa
    $daDangKy = DB::table('lich_bao_cao_giang_vien')
        ->where('lich_bao_cao_id', $request->lich_bao_cao_id)
        ->where('giang_vien_id', $giangVienHuyDangKy->maGiangVien)
        ->exists();

    if (!$daDangKy) {
        return redirect()->back()->with('error', 'Hủy đăng ký thành công!');
    }

    // Hủy đăng ký
    DB::table('lich_bao_cao_giang_vien')
        ->where('lich_bao_cao_id', $request->lich_bao_cao_id)
        ->where('giang_vien_id', $giangVienHuyDangKy->maGiangVien)
        ->delete();

    // Gửi email cho giảng viên lên lịch
    $lichBaoCao = LichBaoCao::with(['giangVien', 'boMon.khoa'])->findOrFail($request->lich_bao_cao_id);
    $giangVienLenLich = $lichBaoCao->giangVien;

    if ($giangVienLenLich && $giangVienLenLich->email) {
        Mail::to($giangVienLenLich->email)->queue(new HuyDangKySHHTMail($lichBaoCao, $giangVienHuyDangKy));
    }


    return redirect()->back()->with('success', 'Hủy đăng ký thành công.');
}

    

}
