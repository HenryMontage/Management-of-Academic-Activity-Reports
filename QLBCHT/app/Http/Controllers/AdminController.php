<?php

namespace App\Http\Controllers;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Quyen;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\GiangVien;
use App\Models\NhanVienPDBCL;
use App\Models\LichBaoCao;
use App\Models\DangKyBaoCao;
use App\Models\BaoCao;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $startOfSemester = $now->month <= 6
            ? Carbon::create($now->year, 1, 1)
            : Carbon::create($now->year, 7, 1);

        return view('admin.dashboard', [
            'tongGiangVien' => GiangVien::count(),
            'tongNhanVien' => NhanVienPDBCL::count(),
            'tongAdmin' => Admin::count(),
            'tongBaoCao' => BaoCao::count(),
            'baoCaoDuocDuyet' => DangKyBaoCao::where('trangThai', 'Đã Duyệt')->count(),
            'tongPhieuDangKy' => DangKyBaoCao::count(),
            'baoCaoTrongThang' => BaoCao::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            'baoCaoTrongKy' => LichBaoCao::whereBetween('created_at', [$startOfSemester, $now])->count(),

            // Biểu đồ theo ngày
            'baoCaoNgay' => BaoCao::selectRaw('DATE(created_at) as ngay, COUNT(*) as soLuong')
                ->groupBy('ngay')
                ->orderBy('ngay')
                ->pluck('soLuong', 'ngay')
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $admins = Admin::with('quyen')->get();
        // return view('admin.index', compact('admins'));

          if ($request->ajax()) {
            return $this->getDataTable();
        }
        
        return view('admin.index');
    }

    private function getDataTable()
    {
        $data = Admin::query(); 

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('quyen', function ($row) {
                return $row->quyen ? $row->quyen->tenQuyen : 'Không có quyền';
            })
            ->addColumn('hanhdong', function ($row) {
                return view('components.action-buttons', [
                    'row' => $row,
                    'editRoute' => 'admin.edit',
                    'deleteRoute' => 'admin.destroy',
                    'id' => $row->maAdmin
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
        $quyens = Quyen::all();
        return view('admin.create', compact('quyens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        // $data = $request->all();
        $data = $request->validated();
        $data['matKhau'] = bcrypt($request->matKhau);
        Admin::create($data);
        return redirect()->route('admin.index')->with('success', 'Thêm admin thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $quyens = Quyen::all();
        return view('admin.edit', compact('admin', 'quyens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, $maAdmin)
    {
        $admin = Admin::findOrFail($maAdmin);
        $data = $request->validated();
        if ($request->filled('matKhau')) {
            $data['matKhau'] = bcrypt($request->matKhau);
        }
        $admin->update($data);   
        
        return redirect()->route('admin.index')->with('success', 'Cập nhật admin thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'Xóa admin thành công');
    }
}
