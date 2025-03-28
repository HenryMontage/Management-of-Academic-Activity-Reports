<?php

namespace App\Http\Controllers;

use App\Models\GiangVien;
use Illuminate\Http\Request;
use App\Models\ChucVu;
use App\Models\BoMon;
use App\Models\Khoa;
use App\Http\Requests\GiangVienRequest;
use App\Http\Requests\UpdateGiangVienRequest;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;


class GiangVienController extends Controller
{
    /**
     * Hiển thị danh sách giảng viên.
     */
    // public function index()
    // {
    //     $giangViens = GiangVien::with(['chucvu', 'bomon'])->get();
    //     return view('giangvien.index', compact('giangViens'));
    // }
public function index(Request $request)
{
    if ($request->ajax()) {
        return $this->getDataTable();
    }

    return view('giangvien.index');
}

private function getDataTable()
{
    $data = GiangVien::with(['chucvu', 'bomon']);

    return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('ho_ten', function ($row) {
            return $row->ho . ' ' . $row->ten; // Ghép họ và tên
        })
        ->addColumn('chucvu', function ($row) {
            return $row->chucvu ? $row->chucvu->tenChucVu : 'Không';
        })
        ->addColumn('bomon', function ($row) {
            return $row->bomon ? $row->bomon->tenBoMon : 'Không';
        })
        ->addColumn('hanhdong', function ($row) {
            return view('components.action-buttons', [
                'row' => $row,
                'editRoute' => 'giangvien.edit',
                'deleteRoute' => 'giangvien.destroy',
                'id' => $row->maGiangVien 
            ])->render();
        })
        ->rawColumns(['hanhdong'])
        ->make(true);
}


    /**
     * Hiển thị form tạo giảng viên.
     */
    public function create()
    {
        $chucVus = ChucVu::all();
        $boMons = BoMon::all();
        return view('giangvien.create', compact('chucVus', 'boMons'));
    }

    /**
     * Xử lý lưu giảng viên mới.
     */
    public function store(GiangVienRequest $request)
    {
        $data = $request->validated();

        // Xử lý ảnh đại diện
        

        if ($request->hasFile('anhDaiDien')) {
            $path = $request->file('anhDaiDien')->store('anhDaiDiens', 'public');
            $data['anhDaiDien'] = $path;
        } else {
            $data['anhDaiDien'] = 'anhDaiDiens/anhmacdinh.jpg'; // Ảnh mặc định
        }

        // Tạo giảng viên
        GiangVien::create([
            'maGiangVien' => $data['maGiangVien'],
            'ho' => $data['ho'],
            'ten' => $data['ten'],
            'email' => $data['email'],
            'sdt' => $data['sdt'],
            'matKhau' => bcrypt($data['matKhau']),
            'chucVu' => $data['chucVu'],
            'boMon_id' => $data['boMon_id'],
            'anhDaiDien' => $data['anhDaiDien'] ?? null
        ]);

        return redirect()->route('giangvien.index')->with('success', 'Thêm giảng viên thành công!');
    }
    
 
    // public function edit(GiangVien $giangvien)
    // {
    //     //$giangvien = GiangVien::where('maGiangVien', $maGiangVien)->firstOrFail();
    //     $chucvus = ChucVu::all(); 
    //     $bomons = BoMon::all(); 
    //     return view('giangvien.edit', compact('giangvien', 'chucvus', 'bomons'));
    // }
    public function edit( $maGiangVien)
    {
        $giangvien = GiangVien::where('maGiangVien', $maGiangVien)->firstOrFail();
        $chucvus = ChucVu::all(); 
        $bomons = BoMon::all(); 
        return view('giangvien.edit', compact('giangvien', 'chucvus', 'bomons'));
    }
    
    // public function update(UpdateGiangVienRequest $request, $maGiangVien)
    // {

    //     $giangvien = GiangVien::where('maGiangVien', $maGiangVien)->firstOrFail();
    
    //     $data = $request->validated();
    
    //     if ($request->hasFile('anhDaiDien')) {
    //         if ($giangvien->anhDaiDien) {
    //             Storage::disk('public')->delete($giangvien->anhDaiDien);
    //         }
    //         $path = $request->file('anhDaiDien')->store('anhDaiDiens', 'public');
    //         $data['anhDaiDien'] = $path;
    //     }

    //     // Xử lý mật khẩu: chỉ cập nhật nếu người dùng nhập mới
    //     if (!empty($request->matKhau)) {
    //         $data['matKhau'] = bcrypt($request->matKhau);
    //     } else {
    //         unset($data['matKhau']); // Không thay đổi mật khẩu nếu không nhập
    //     }
    
    //     $giangvien->update($data);
    //     return redirect()->route('giangvien.index')->with('success', 'Cập nhật giảng viên thành công!');
    // }

    public function update(UpdateGiangVienRequest $request, $maGiangVien)
{
    $giangvien = GiangVien::where('maGiangVien', $maGiangVien)->firstOrFail();
    dd($giangvien);
    $data = $request->validated();

    // Xử lý ảnh đại diện
    if ($request->hasFile('anhDaiDien')) {
        if ($giangvien->anhDaiDien) {
            Storage::disk('public')->delete($giangvien->anhDaiDien);
        }
        $data['anhDaiDien'] = $request->file('anhDaiDien')->store('anhDaiDiens', 'public');
    }

    // Xử lý mật khẩu (chỉ cập nhật nếu có nhập mới)
    if (!empty($request->matKhau)) {
        $data['matKhau'] = bcrypt($request->matKhau);
    }

    // Cập nhật thông tin giảng viên
    $giangvien->update([
        'ho' => $data['ho'],
        'ten' => $data['ten'],
        'email' => $data['email'],
        'sdt' => $data['sdt'],
        'chucVu' => $data['chucVu'],
        'boMon_id' => $data['boMon_id'],
        'anhDaiDien' => $data['anhDaiDien'] ?? $giangvien->anhDaiDien,
        'matKhau' => $data['matKhau'] ?? $giangvien->matKhau,
    ]);

    return redirect()->route('giangvien.index')->with('success', 'Cập nhật giảng viên thành công!');
}

    



    // public function update(UpdateGiangVienRequest $request, $maGiangVien)
    // {

    //     $giangvien = GiangVien::where('maGiangVien', $maGiangVien)->firstOrFail();
    //     $data = $request->validated();

    //     // Cập nhật ảnh đại diện
    //     if ($request->hasFile('anhDaiDien')) {
    //         // Xóa ảnh cũ nếu có
    //         if ($giangvien->anhDaiDien) {
    //             Storage::disk('public')->delete($giangvien->anhDaiDien);
    //         }
    //         $path = $request->file('anhDaiDien')->store('anhDaiDiens', 'public');
    //         $data['anhDaiDien'] = $path;
    //     }

    //     // Cập nhật thông tin
    //     $giangvien->update($data);

    //     return redirect()->route('giangvien.index')->with('success', 'Cập nhật giảng viên thành công!');
        
    //     // $giangvien = GiangVien::where('maGiangVien', $maGiangVien)->firstOrFail();

    //     // // Get all fields that should be updated, including email and sdt
    //     // $data = $request->only(['ho', 'ten', 'email', 'sdt', 'chucVu', 'boMon_id']);

    //     // // Update password only if provided
    //     // if ($request->filled('matKhau')) {
    //     //     $data['matKhau'] = bcrypt($request->matKhau);
    //     // }

    //     // // Update the lecturer with the validated data
    //     // $giangvien->update($data);

    //     // return redirect()->route('giangvien.index')->with('success', 'Cập nhật giảng viên thành công!');
    // }



    /**
     * Xóa giảng viên.
     */
    public function destroy($maGiangVien)
    {
        $giangVien = GiangVien::where('maGiangVien', $maGiangVien)->firstOrFail();

        // Xóa ảnh đại diện
        if ($giangVien->anhDaiDien) {
            Storage::disk('public')->delete($giangVien->anhDaiDien);
        }

        $giangVien->delete();
        return redirect()->route('giangvien.index')->with('success', 'Xóa giảng viên thành công!');
    }
}
