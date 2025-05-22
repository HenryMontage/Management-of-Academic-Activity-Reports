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

use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;



class GiangVienController extends Controller
{

public function index(Request $request)
{
    if ($request->ajax()) {
        return $this->getDataTable();
    }

    return view('giangvien.index');
}

private function getDataTable()
{
    $data = GiangVien::with(['chucVuObj', 'bomon']);

    return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('ho_ten', function ($row) {
            return $row->ho . ' ' . $row->ten; // Ghép họ và tên
        })
        ->addColumn('chucVuObj', function ($row) {
            return $row->chucVuObj ? $row->chucVuObj->tenChucVu : 'Không';
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
    
    public function edit( $maGiangVien)
    {
        $giangvien = GiangVien::where('maGiangVien', $maGiangVien)->firstOrFail();
        $chucvus = ChucVu::all(); 
        $bomons = BoMon::all(); 
        return view('giangvien.edit', compact('giangvien', 'chucvus', 'bomons'));
    }
    

    public function update(UpdateGiangVienRequest $request, $maGiangVien)
    {
        $giangvien = GiangVien::findOrFail($maGiangVien);
        $data = $request->validated();

        // Xử lý ảnh đại diện
        if ($request->hasFile('anhDaiDien')) {
            // Xóa ảnh cũ nếu không phải ảnh mặc định
            if ($giangvien->anhDaiDien && $giangvien->anhDaiDien !== 'anhDaiDiens/anhmacdinh.jpg') {
                Storage::disk('public')->delete($giangvien->anhDaiDien);
            }
    
            $path = $request->file('anhDaiDien')->store('anhDaiDiens', 'public');
            $data['anhDaiDien'] = $path;
        }

        // Xử lý mật khẩu (chỉ cập nhật nếu có nhập mới)
        if ($request->filled('matKhau')) {
            $data['matKhau'] = bcrypt($request->matKhau);
        } else {
            unset($data['matKhau']);
        }
        

        // Cập nhật thông tin giảng viên
        $giangvien->update($data);  

        return redirect()->route('giangvien.index')->with('success', 'Cập nhật giảng viên thành công!');
    }



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
    
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);
    
        try {
            $spreadsheet = IOFactory::load($request->file('file')->getPathName());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true); // A, B, C,...
    
            // Bỏ dòng tiêu đề
            unset($rows[1]);
    
            $imported = 0;
            $skippedRows = [];
    
            foreach ($rows as $index => $row) {
                // Bỏ qua dòng nếu thiếu mã giảng viên
                if (!isset($row['A']) || empty($row['A'])) continue;
    
                // Validator
                $validator = Validator::make($row, [
                    'A' => 'required|string',   // maGiangVien
                    'B' => 'required|string',   // ho
                    'C' => 'required|string',   // ten
                    'D' => 'required|string',    // sdt
                    'E' => 'required|string',   // email
                    'F' => 'required|string',   // matKhau
                    'G' => 'nullable|string',  // chucVu (int trong DB)
                    'H' => 'nullable|string',   // boMon_id (varchar trong DB)
                ]);
    
                if ($validator->fails()) {
                    $errors = implode(', ', $validator->errors()->all());
                    $skippedRows[] = "Dòng $index: $errors";
                    continue;
                }
                if (GiangVien::where('maGiangVien', $row['A'])->exists()) {
                    $skippedRows[] = $index + 1;
                    continue;
                }
    
                // Tạo hoặc cập nhật giảng viên
                GiangVien::updateOrCreate(
                    ['maGiangVien' => $row['A']],
                    [
                        'ho' => $row['B'],
                        'ten' => $row['C'],
                        'sdt' => '0'.strval($row['D']),
                        'email' => $row['E'],
                        'matKhau' => bcrypt($row['F']),
                        'chucVu' => $row['G'] ?? null,
                        'boMon_id' => $row['H'] ?? null,
                    ]
                );
    
                $imported++;
            }
    
            // Xử lý kết quả
            if ($imported === 0) {
                return back()->with('error', 'Không import được giảng viên nào.')->with('warning', implode("\n", $skippedRows));
            }   
    
            return redirect()->route('giangvien.index')->with('success', "Đã import $imported giảng viên thành công.");
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi import: ' . $e->getMessage());
        }
    }


    // public function dsGiangVien()
    // {
    //     $boMons = BoMon::with('giangViens')->get();

    //     return view('giangvien.dsgv', compact('boMons'));
    // }

    public function dsGiangVien(Request $request)
{
    $keyword = $request->keyword;

    $boMons = BoMon::withCount('giangViens')
        ->with(['giangViens' => function ($query) {
            $query->with('chucVuObj');
        }])
        ->when($keyword, function ($query, $keyword) {
            $query->where('tenBoMon', 'like', "%$keyword%");
        })
        ->paginate(6); // Số lượng bộ môn mỗi trang

    return view('giangvien.dsgv', compact('boMons', 'keyword'));
}


    
}
