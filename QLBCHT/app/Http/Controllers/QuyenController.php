<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quyen;
use Yajra\DataTables\Facades\DataTables;
class QuyenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $quyens = Quyen::all();
    //     return view('quyen.index', compact('quyens'));
    // }
    public function index(Request $request)
{
    if ($request->ajax()) {
        return $this->getDataTable();
    }

    return view('quyen.index');
}

private function getDataTable()
{
    $quyens = Quyen::query(); // có thể thêm with() nếu cần quan hệ sau này

    return DataTables::of($quyens)
        ->addIndexColumn()
        ->addColumn('nhomRoute', function ($quyen) {
            return is_array($quyen->nhomRoute) ? implode(', ', $quyen->nhomRoute) : 'Không có';
        })
        ->addColumn('nhomRoute', function ($quyen) {
            $mapping = [
                'admin' => 'Quản trị viên',
                'nhanvien' => 'Nhân viên PĐBCL',
                'giangvien' => 'Giảng viên',
                'khoa' => 'Khoa',
                'bomon' => 'Bộ môn',
                'chucvu' => 'Chức vụ',
                'quyen' => 'Quyền',
                'email' => 'Email',
                'lichbaocao' => 'Lịch báo cáo',
                'dangkybaocao' => 'Đăng ký báo cáo',
                'baocao' => 'Báo cáo',
                'bienban' => 'Biên bản',
                'duyet' => 'Xác nhận phiếu đăng ký',
                'xacnhan' => 'Xác nhận biên bản',
            ];
        
            if (is_array($quyen->nhomRoute)) {
                $translated = array_map(function ($route) use ($mapping) {
                    return $mapping[$route] ?? $route;
                }, $quyen->nhomRoute);
                return implode(', ', $translated);
            }
        
            return 'Không có';
        })
        ->addColumn('hanhdong', function ($quyen) {
            return view('components.action-buttons', [
                'row' => $quyen,
                'editRoute' => 'quyen.edit',
                'deleteRoute' => 'quyen.destroy',
                'id' => $quyen->maQuyen
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
        return view('quyen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenQuyen' => 'required|string|max:255',
            'nhomRoute' => 'array|nullable'
        ]);

        Quyen::create([
            'tenQuyen' => $request->tenQuyen,
            'nhomRoute' => $request->nhomRoute ?? [],
        ]);

        return redirect()->route('quyen.index')->with('success', 'Thêm quyền thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($maQuyen)
    {
        $quyen = Quyen::findOrFail($maQuyen);
        return view('quyen.edit', compact('quyen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $quyen = Quyen::findOrFail($id);

        $request->validate([
            'tenQuyen' => 'required|string|max:255',
            'nhomRoute' => 'array|nullable'
        ]);

        $quyen->update([
            'tenQuyen' => $request->tenQuyen,
            'nhomRoute' => $request->nhomRoute ?? [],
        ]);

        return redirect()->route('quyen.index')->with('success', 'Cập nhật quyền thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($maQuyen)
    {
        Quyen::findOrFail($maQuyen)->delete();
        return redirect()->route('quyen.index')->with('success', 'Xóa quyền thành công');
    }
}
