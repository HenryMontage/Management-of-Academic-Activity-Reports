<?php

namespace App\Http\Controllers;

use App\Models\BienBanBaoCao;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\LichBaoCao;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\ThongBaoGuiBienBan;

class BienBanController extends Controller
{
    //Hiển thị danh sách biên bản
    public function index(Request $request)
    {
        $giangVien = Auth::guard('giang_viens')->user();
    
        $query = BienBanBaoCao::with('lichBaoCao')
            ->where('giangVien_id', $giangVien->maGiangVien);
    
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where( function ($q) use ($keyword) {
                $q->whereHas('lichBaoCao', function ($subQ) use ($keyword){
                    $subQ->where('chuDe', 'like', '%' . $keyword . '%');
                })
                ->orWhere('trangThai', 'like', '%' . $keyword . '%')
                ->orWhere('ngayNop', 'like', '%' . $keyword . '%');
            });
        }
    
        $bienbans = $query->orderByDesc('ngayNop')->paginate(6);
    
        return view('bienban.index', compact('bienbans'));
    }
    

 
    // Hiển thị form tạo mới
    public function create()
    {
        $lichBaoCaos = LichBaoCao::whereHas('dangKyBaoCaos', function ($query) {
            $query->where('trangThai', 'Đã Xác Nhận');
        })->doesntHave('bienBanBaoCaos')->get();
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
        $giangvien = Auth::guard('giang_viens')->user();
        $file = $request->file('fileBienBan');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/bienban', $fileName); 
        $bienban = BienBanBaoCao::create([
            'maBienBan' => 'BB' . mt_rand(1000, 9999),
            'ngayNop' => now(),
            'fileBienBan' =>'storage/bienban/' . $fileName,
            'lichBaoCao_id' => $request->lich_bao_cao_id, 
            'trangThai' => 'Chờ Xác Nhận',
            'giangVien_id' => $giangvien->maGiangVien,
        ]);

        Notification::create([
            'loai' => 'bien_ban',
            'noiDung' => 'Có biên bản sinh hoạt học thuật cần xác nhận!',
            'link' => route('xacnhan.index'),
            'doiTuong' => 'nhan_vien'
        ]);

        $nhanViens = \App\Models\NhanVienPDBCL::all(); // hoặc lọc theo bộ môn/khoa
        foreach ($nhanViens as $nv) {
            Mail::to($nv->email)->queue(new ThongBaoGuiBienBan($bienban));

        }

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

        
        if ($bienban->trangThai !== 'Chờ Xác Nhận') {
            return redirect()->back()->with('error', 'Chỉ có thể xoá biên bản khi trạng thái là "Chờ Xác Nhận"!');
        }
        // Xóa file nếu có
        if ($bienban->fileBienBan && file_exists(public_path($bienban->fileBienBan))) {
            unlink(public_path($bienban->fileBienBan));
        }

        $bienban->delete();

        return redirect()->route('bienban.index')->with('success', 'Xóa biên bản thành công!');
    }

}
