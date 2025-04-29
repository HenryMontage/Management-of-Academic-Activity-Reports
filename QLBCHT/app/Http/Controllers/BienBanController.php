<?php

namespace App\Http\Controllers;

use App\Models\BienBanBaoCao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\LichBaoCao;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BienBanController extends Controller
{
    // Hiển thị danh sách biên bản
    // public function index()
    // {
    //     $bienbans = BienBanBaoCao::where('nhanVien_id', Auth::user()->maNV)->get();
    //     return view('bienban.index', compact('bienbans'));
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTable();
        }
    
        return view('bienban.index');
    }
        
        private function getDataTable()
        {
            $nv = Auth::guard('nhan_vien_p_d_b_c_ls')->user();
    
        $data = BienBanBaoCao::where('nhanVien_id', $nv->maNV)->latest();
    
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('file', function($row) {
                if ($row->duongDanFile) {
                    return '<a href="'.asset($row->fileBienBan).'" target="_blank">Tải file</a>';
                }
                return 'Không có file';
            })
            ->addColumn('chuDe', function($row) {
                return $row->lichBaoCao ? $row->lichBaoCao->chuDe : 'Không có chủ đề';
            })            
            ->addColumn('hanhdong', function($row) {
                $downloadLink = '';
                if ($row->fileBienBan) {
                    $downloadLink = '<a href="'.asset($row->fileBienBan).'" class="btn btn-sm btn-primary" style="color:#fff" target="_blank"><i class="fas fa-download"></i> Tải File</a>';
                }
            
                $deleteButton = view('components.action-buttons', [
                    'row' => $row,
                    'editRoute' => null, // Không cần route edit
                    'deleteRoute' => 'bienban.destroy',
                    'id' => $row->maBienBan
                ])->render();
            
                return '<div class="d-flex gap-1">'.$downloadLink . $deleteButton.'</div>';
    
            })
            ->rawColumns(['hanhdong'])
            ->make(true);
        }

    // Hiển thị form tạo mới
    public function create()
    {
        $lichBaoCaos = LichBaoCao::all();
        return view('bienban.create',compact('lichBaoCaos'));
    }

    // Lưu biên bản mới
    public function store(Request $request)
    {
        $request->validate([
            'fileBienBan' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:20240', 
        ]);
        $lich = LichBaoCao::find($request->lich_bao_cao_id);
        $nhanvien = Auth::guard('nhan_vien_p_d_b_c_ls')->user();
        $file = $request->file('fileBienBan');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/bienban', $fileName); 
        BienBanBaoCao::create([
            'maBienBan' => 'BB' . mt_rand(1000, 9999),
            'ngayNop' => now(),
            'fileBienBan' =>'storage/bienban/' . $fileName,
            'lichBaoCao_id' => $request->lich_bao_cao_id, 
            'trangThai' => 'Chờ Duyệt',
            'nhanVien_id' => $nhanvien->maNV,
        ]);

        return redirect()->route('bienban.index')->with('success', 'Gửi biên bản thành công.');
    }

    // Hiển thị form sửa biên bản
    public function edit($id)
    {
        $bienban = BienBanBaoCao::where('maBienBan', $id)->where('nhanVien_id', Auth::user()->maNV)->firstOrFail();
        return view('bienban.edit', compact('bienban'));
    }

    // Cập nhật biên bản
    public function update(Request $request, $id)
    {
        $bienban = BienBanBaoCao::where('maBienBan', $id)->where('nhanVien_id', Auth::user()->maNV)->firstOrFail();

        $request->validate([
            'fileBienBan' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
        ]);

        if ($request->hasFile('fileBienBan')) {
            $file = $request->file('fileBienBan');
            $path = $file->store('bienban', 'public');
            $bienban->fileBienBan = $path;
        }

        $bienban->save();

        return redirect()->route('bienban.index')->with('success', 'Cập nhật biên bản thành công.');
    }

    // Xóa biên bản
    public function destroy($maBienBan)
    {
        $bienban = BienBanBaoCao::where('maBienBan', $maBienBan)->firstOrFail(); // thêm firstOrFail()

        // Xóa file nếu có
        if ($bienban->fileBienBan && file_exists(public_path($bienban->fileBienBan))) {
            unlink(public_path($bienban->fileBienBan));
        }

        $bienban->delete();

        return redirect()->route('bienban.index')->with('success', 'Xóa biên bản thành công.');
    }

}
