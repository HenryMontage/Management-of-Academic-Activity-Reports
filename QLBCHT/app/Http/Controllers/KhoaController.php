<?php

namespace App\Http\Controllers;

use App\Models\Khoa;
use App\Models\GiangVien;
use Illuminate\Http\Request;
use App\Http\Requests\KhoaRequest;
use App\Http\Requests\UpdateKhoaRequest;
use Yajra\DataTables\Facades\DataTables;


class KhoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $khoa;
    public function __construct(Khoa $khoa){
        $this->khoa = $khoa;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTable();
        }
        
        return view('khoa.index');
    }

    private function getDataTable()
    {
        $data = Khoa::with('truong_Khoa');
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('truong_khoa', function($khoa) {
                return optional($khoa->truong_Khoa)->ho ? $khoa->truong_Khoa->ho . ' ' . $khoa->truong_Khoa->ten : 'Không';
            })
            ->addColumn('hanhdong', function($khoa) {
                return view('components.action-buttons', [
                    'row' => $khoa,
                    'editRoute' => 'khoa.edit',
                    'deleteRoute' => 'khoa.destroy',
                    'id' => $khoa->maKhoa
                ])->render();
            })
            ->rawColumns(['hanhdong'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $giangviens = GiangVien::all();
        return view('khoa.create', compact('giangviens'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KhoaRequest $request)
    {
        Khoa::create([
            'maKhoa' => $request->maKhoa, // Thêm mã khoa
            'tenKhoa' => $request->tenKhoa,
            'truongKhoa' => $request->truongKhoa ?? null, // Nếu không chọn trưởng khoa thì lưu null
        ]);

    
        return redirect()->route('khoa.index')->with('success', 'Thêm khoa thành công!');
    }
    
    
    /**
     * Display the specified resource.
     */
    public function show(Khoa $khoa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Khoa $khoa)
{
    $giangviens = GiangVien::all();
    return view('khoa.edit', compact('khoa','giangviens'));
}

public function update(UpdateKhoaRequest $request, Khoa $khoa)
{
    $khoa->update([
        'tenKhoa' => $request->tenKhoa,
        'truongKhoa' => $request->truongKhoa,
    ]);

    return redirect()->route('khoa.index')->with('success', 'Cập nhật khoa thành công!');
}





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Khoa $khoa)
    {
        $khoa->delete();

        return redirect()->route('khoa.index')->with('success', 'Xóa khoa thành công!');
    }
}
