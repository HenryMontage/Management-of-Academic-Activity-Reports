<?php

namespace App\Http\Controllers;
use App\Models\NhanVienPDBCL;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNhanVienRequest;
use App\Http\Requests\UpdateNhanVienRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Quyen;
use Yajra\DataTables\Facades\DataTables;
class NhanVienPDBCLController extends Controller
{
    public function index(Request $request)
    {

          if ($request->ajax()) {
            return $this->getDataTable();
        }
        
        return view('nhanvien.index');
    }

    private function getDataTable()
    {
        $data = NhanVienPDBCL::query(); 

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('quyen', function ($row) {
                return $row->quyen ? $row->quyen->tenQuyen : 'Không có quyền';
            })
            ->addColumn('ho_ten', function ($row) {
                return $row->ho . ' ' . $row->ten; // Ghép họ và tên
            })
            ->addColumn('anhDaiDien', function ($row) {
                $src = $row->anhDaiDien 
                    ? asset('storage/' . $row->anhDaiDien) 
                    : 'https://ui-avatars.com/api/?name=' . urlencode($row->ho . ' ' . $row->ten) . '&background=0D8ABC&color=fff';
            
                return '<img src="' . $src . '" 
                            alt="Ảnh đại diện" 
                            class="img-fluid rounded-circle shadow" 
                            style="width: 50px; height: 50px; object-fit: cover;">';
            })            
            ->addColumn('hanhdong', function ($row) {
                return view('components.action-buttons', [
                    'row' => $row,
                    'editRoute' => 'nhanvien.edit',
                    'deleteRoute' => 'nhanvien.destroy',
                    'id' => $row->maNV
                ])->render();
            })
            ->rawColumns(['hanhdong', 'anhDaiDien'])
            ->make(true);
    }

    public function create()
    {
        $quyens = Quyen::all();
        return view('nhanvien.create',compact('quyens'));
    }

    public function store(StoreNhanVienRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('anhDaiDien')) {
            $path = $request->file('anhDaiDien')->store('anhDaiDiens', 'public');
            $data['anhDaiDien'] = $path;
        } else {
            $data['anhDaiDien'] = null;
        }

        $data['matKhau'] = bcrypt($data['matKhau']);

        NhanVienPDBCL::create($data);

        return redirect()->route('nhanvien.index')->with('success', 'Thêm nhân viên thành công!');
    }

    public function edit($maNV)
    {
        $quyens = Quyen::all();
        $nhanvien = NhanVienPDBCL::findOrFail($maNV);
        return view('nhanvien.edit', compact('nhanvien','quyens'));
    }


    public function update(UpdateNhanVienRequest $request, $maNV)
    {
        $nhanvien = NhanVienPDBCL::findOrFail($maNV);
        $data = $request->validated();
    
        if ($request->hasFile('anhDaiDien')) {
            // Xóa ảnh cũ nếu không phải ảnh mặc định
            if ($nhanvien->anhDaiDien && $nhanvien->anhDaiDien !== 'anhDaiDiens/anhmacdinh.jpg') {
                Storage::disk('public')->delete($nhanvien->anhDaiDien);
            }
    
            $path = $request->file('anhDaiDien')->store('anhDaiDiens', 'public');
            $data['anhDaiDien'] = $path;
        }
    
        $nhanvien->update($data);
    
        return redirect()->route('nhanvien.index')->with('success', 'Cập nhật nhân viên thành công!');
    }
    
    public function destroy($maNV)
    {
        $nhanvien = NhanVienPDBCL::findOrFail($maNV);

        if ($nhanvien->anhDaiDien && $nhanvien->anhDaiDien !== 'anhDaiDiens/anhmacdinh.jpg') {
            Storage::disk('public')->delete($nhanvien->anhDaiDien);
        }

        $nhanvien->delete();

        return redirect()->route('nhanvien.index')->with('success', 'Xóa nhân viên thành công!');
    }

}
