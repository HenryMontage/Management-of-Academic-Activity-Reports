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
use App\Models\BoMon;
use App\Models\BienBanBaoCao;
use Carbon\Carbon;

class AdminController extends Controller
{
public function dashboard(Request $request)
{
    $now = Carbon::now();

    // Ngày lọc từ form
    $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date'))->startOfDay() : null;
    $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date'))->endOfDay() : null;

    // Mặc định: tháng và kỳ
    $startOfMonth = $now->copy()->startOfMonth();
    $endOfMonth = $now->copy()->endOfMonth();
    $startOfSemester = $now->month <= 6
        ? Carbon::create($now->year, 1, 1)
        : Carbon::create($now->year, 7, 1);

    // Áp dụng điều kiện ngày lọc nếu có
    $baoCaoQuery = BaoCao::query();
    $bienBanQuery = BienBanBaoCao::query();
    $lichBaoCaoQuery = LichBaoCao::query();
    $phieuDangKyQuery = DangKyBaoCao::query();
    if ($fromDate && $toDate) {
        $baoCaoQuery->whereBetween('created_at', [$fromDate, $toDate]);
        $bienBanQuery->whereBetween('created_at', [$fromDate, $toDate]);
        $phieuDangKyQuery->whereBetween('created_at', [$fromDate, $toDate]);
        $lichBaoCaoQuery->whereBetween('created_at', [$fromDate, $toDate]);
    }

    $notifications = collect();

    // Phiếu đăng ký được duyệt gần nhất
    $phieuDangKy = DangKyBaoCao::where('trangThai', 'Đã Xác Nhận')->latest()->first();
    if ($phieuDangKy) {
        $notifications->push([
            'icon' => 'fas fa-check',
            'bg' => 'success',
            'text' => 'Phiếu đăng ký SHHT được xác nhận',
            'time' => $phieuDangKy->created_at->diffForHumans(),
        ]);
    }
    
    // Giảng viên mới đăng ký gần nhất
    $giangVien = GiangVien::latest()->first();
    if ($giangVien) {
        $notifications->push([
            'icon' => 'fas fa-user',
            'bg' => 'info',
            'text' => 'Giảng viên mới được thêm',
            'time' => $giangVien->created_at->diffForHumans(),
        ]);
    }

    $bienBan = BienBanBaoCao::where('trangThai', 'Đã Xác Nhận')->latest()->first();
    if ($bienBan) {
        $notifications->push([
            'icon' => 'fas fa-check',
            'bg' => 'info',
            'text' => 'Biên bản mới được xác nhận',
            'time' => $bienBan->created_at->diffForHumans(),
        ]);
    }
    
    // Lịch báo cáo mới được tạo gần nhất
    $lich = LichBaoCao::latest()->first();
    if ($lich) {
        $notifications->push([
            'icon' => 'fas fa-calendar',
            'bg' => 'warning',
            'text' => 'Lịch báo cáo mới được tạo',
            'time' => $lich->created_at->diffForHumans(),
        ]);
    }
    
    // Sắp xếp lại theo thời gian (mới nhất trên cùng)
    $notifications = $notifications->sortByDesc('time')->values();


    return view('admin.dashboard', [
        'tongGiangVien' => GiangVien::count(),
        'tongNhanVien' => NhanVienPDBCL::count(),
        'tongAdmin' => Admin::count(),
        'baoCaoTheoThang' => BaoCao::selectRaw('MONTH(created_at) as thang, COUNT(*) as soLuong')
        ->groupBy('thang')
        ->orderBy('thang')
        ->pluck('soLuong', 'thang'),
        'baoCaoTheoBoMon' => BoMon::withCount(['giangViens as soLuongBaoCao' => function ($query) use ($fromDate, $toDate) {
            $query->join('bao_caos', 'giang_viens.maGiangVien', '=', 'bao_caos.giangVien_id');
            if ($fromDate && $toDate) {
                $query->whereBetween('bao_caos.created_at', [$fromDate, $toDate]);
            }
        }])->get()->pluck('soLuongBaoCao', 'tenBoMon'),
        'notifications' => $notifications,


        'tongBaoCao' => $baoCaoQuery->count(),
        'tongBienBan' => $bienBanQuery->count(),
        'tongLichBaoCao' => $lichBaoCaoQuery->count(),
        'tongPhieuDangKy' => $phieuDangKyQuery->count(),
        'bienBanDuocXacNhan' => $bienBanQuery->where('trangThai', 'Đã Xác Nhận')->count(),
        'phieuDuocXacNhan' => $phieuDangKyQuery->where('trangThai', 'Đã Xác Nhận')->count(),

        'baoCaoNgay' => BaoCao::selectRaw('DATE(created_at) as ngay, COUNT(*) as soLuong')
            ->when($fromDate && $toDate, fn($q) => $q->whereBetween('created_at', [$fromDate, $toDate]))
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
            ->addColumn('ho_ten', function ($row) {
                return $row->ho . ' ' . $row->ten; // Ghép họ và tên
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
        }else {
            unset($data['matKhau']);
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
