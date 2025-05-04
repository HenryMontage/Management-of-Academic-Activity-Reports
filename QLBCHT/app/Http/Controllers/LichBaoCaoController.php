<?php

namespace App\Http\Controllers;

use App\Models\LichBaoCao;
use App\Models\BaoCao;
use App\Models\GiangVien;
use App\Models\BoMon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\LichBaoCaoRequest;
use App\Mail\ThongBaoLichBaoCao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
class LichBaoCaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $lichBaoCaos = LichBaoCao::with('giangVienPhuTrach', 'boMon')->get();
    //     return view('lichbaocao.index', compact('lichBaoCaos'));
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTable();
        }

        return view('lichbaocao.index');
    }

private function getDataTable()
{
    
    $lichBaoCaos = LichBaoCao::with('giangVienPhuTrach', 'boMon');

    return DataTables::of($lichBaoCaos)
        ->addIndexColumn()
        ->editColumn('gioBaoCao', function ($row) {
            return \Carbon\Carbon::parse($row->gioBaoCao)->format('h:i') . 
                   ( \Carbon\Carbon::parse($row->gioBaoCao)->format('A') == 'AM' ? ' SA' : ' CH');
        })
        ->editColumn('hanGioNop', function ($row) {
            return \Carbon\Carbon::parse($row->hanGioNop)->format('h:i') . 
                   ( \Carbon\Carbon::parse($row->hanGioNop)->format('A') == 'AM' ? ' SA' : ' CH');
        })
        ->addColumn('boMon', function($lich) {
            return $lich->boMon ? $lich->boMon->tenBoMon : 'Không xác định';
        })
        ->addColumn('giangVienPhuTrach', function($lich) {
            return $lich->giangVienPhuTrach->map(function($gv) {
                return $gv->ho . ' ' . $gv->ten;
            })->implode(', ');
        })
        ->addColumn('hanhdong', function($lich) {

            $guard = session('current_guard');
            $user = Auth::guard($guard)->user();
            $viewBtn = '<button class="btn btn-primary btn-sm btn-view-bc" style="padding:2px" data-id="'.$lich->maLich.'">
            <i class="fas fa-eye me-1"></i> Báo cáo đã nộp
            </button>';
            $actionBtns = ''; 
            if($guard === 'giang_viens' && in_array($user->chucVuObj->tenChucVu, ['Trưởng Bộ Môn', 'Trưởng Khoa'])) {
                $actionBtns = view('components.action-buttons', [
                    'row' => $lich,
                    'editRoute' => 'lichbaocao.edit',
                    'deleteRoute' => 'lichbaocao.destroy',
                    'id' => $lich->maLich
                ])->render();
                
            }
            return '<div class="d-flex gap-1">'.$viewBtn . $actionBtns.'</div>';
        })
        ->rawColumns(['hanhdong'])
        ->make(true);
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
              
        // $lichBaoCao = LichBaoCao::create($request->only([
        //     'ngayBaoCao', 'gioBaoCao', 'chuDe', 'hanNgayNop', 'hanGioNop', 'boMon_id'
        // ]));

        // $lichBaoCao = LichBaoCao::create($request->validated());

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
        
        foreach ($lichBaoCao->giangVienPhuTrach as $gv) {
            Mail::to($gv->email)->queue(new ThongBaoLichBaoCao($lichBaoCao));
        }
        
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
        // $validated = $request->validate([
        //     'chuDe' => 'required|string|max:255',
        //     'ngayBaoCao' => 'required|date',
        //     'gioBaoCao' => 'required',
        //     'boMon_id' => 'required|exists:bo_mons,maBoMon',
        //     'giangVien_id' => 'array', 
        //     'giangVien_id.*' => 'exists:giang_viens,maGiangVien',
        // ]);
    
        // $lich = LichBaoCao::where('maLich', $maLich)->firstOrFail();
    
        // $lich->update([
        //     'chuDe' => $validated['chuDe'],
        //     'ngayBaoCao' => $validated['ngayBaoCao'],
        //     'gioBaoCao' => $validated['gioBaoCao'],
        //     'boMon_id' => $validated['boMon_id'],
        // ]);
        // Cập nhật giảng viên phụ trách
        // $lich->giangVienPhuTrach()->sync($validated['giangVien_id'] ?? []);
    
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
        LichBaoCao::findOrFail($maLich)->delete();
        return redirect()->route('lichbaocao.index')->with('success', 'Lịch báo cáo đã bị xóa.');
    }
    

    

}
