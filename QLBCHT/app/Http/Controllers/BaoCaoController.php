<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BaoCao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
class BaoCaoController extends Controller
{

    // public function index()
    // {
    // $giangVien = Auth::guard('giang_viens')->user();

    // // Lấy danh sách báo cáo của giảng viên đang đăng nhập
    // $baoCaos = $giangVien->baoCao()->latest()->get();  // Chỉnh sửa tên phương thức quan hệ đúng: 'baoCaos'

    // // Trả về view với danh sách báo cáo
    // return view('baocao.index', compact('baoCaos'));
    // }

    public function index(Request $request)
{
    if ($request->ajax()) {
        return $this->getDataTable();
    }

    return view('baocao.index');
}
    
    private function getDataTable()
    {
        $giangVien = Auth::guard('giang_viens')->user();

    $data = BaoCao::where('giangvien_id', $giangVien->maGiangVien)->latest();

    return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('ngayNop', function($row) {
            return Carbon::parse($row->ngayNop)->format('d/m/Y');
        })
        ->addColumn('file', function($row) {
            if ($row->duongDanFile) {
                return '<a href="'.asset($row->duongDanFile).'" target="_blank">Tải file</a>';
            }
            return 'Không có file';
        })
        // ->addColumn('hanhdong', function($row) {
        //     return view('components.action-buttons', [
        //         'row' => $row,
        //         'editRoute' => 'baocao.edit',
        //         'deleteRoute' => 'baocao.destroy',
        //         'id' => $row->maBaoCao
        //     ])->render();
        // })
        // ->rawColumns(['file', 'hanhdong'])
        ->addColumn('hanhdong', function($row) {
            $downloadLink = '';
            if ($row->duongDanFile) {
                $downloadLink = '<a href="'.asset($row->duongDanFile).'" class="btn btn-sm btn-info" target="_blank"><i class="fas fa-download"></i> Tải File</a>';
            }
        
            $deleteButton = view('components.action-buttons', [
                'row' => $row,
                'editRoute' => null, // Không cần route edit
                'deleteRoute' => 'baocao.destroy',
                'id' => $row->maBaoCao
            ])->render();
        
            return '<div class="d-flex gap-1">'.$downloadLink . $deleteButton.'</div>';

        })
        ->rawColumns(['hanhdong'])
        ->make(true);
    }
    public function create()
    {
        return view('baocao.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenBaoCao' => 'required|string|max:255',
            'ngayNop' => 'required|date',
            'dinhDang' => 'required|string',
            'tomTat' => 'required|string',
            'files.*' => 'required|file|mimes:pdf,docx,ppt,pptx|max:20480' // 20MB mỗi file
        ]);

        $user = Auth::guard('giang_viens')->user();
        $giangVienId = $user->maGiangVien;

        $giangVien = Auth::guard('giang_viens')->user();

    foreach ($request->file('files') as $file) {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/baocaodanop', $fileName);
        $dinhDang = $file->getClientOriginalExtension();

        BaoCao::create([
            'tenBaoCao' => $request->tenBaoCao,
            'ngayNop' => $request->ngayNop,
            'dinhDang' => $dinhDang,
            'tomTat' => $request->tomTat,
            'duongDanFile' => 'storage/baocaodanop/' . $fileName,
            'giangVien_id' => $giangVien->maGiangVien,
        ]);
    }

    return redirect()->route('baocao.index')->with('success', 'Đã nộp báo cáo thành công!');
    }

    public function destroy($maBaoCao)
    {
        $baoCao = BaoCao::findOrFail($maBaoCao); // dùng maBaoCao
        // Xóa file nếu có
        if ($baoCao->duongDanFile && file_exists(public_path('storage/' . $baoCao->duongDanFile))) {
            unlink(public_path('storage/' . $baoCao->duongDanFile));
        }
        $baoCao->delete();
        return redirect()->back()->with('success', 'Đã xóa báo cáo thành công.');
    }

}

