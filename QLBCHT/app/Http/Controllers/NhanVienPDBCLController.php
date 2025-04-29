<?php

namespace App\Http\Controllers;
use App\Models\NhanVienPDBCL;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNhanVienRequest;
use App\Http\Requests\UpdateNhanVienRequest;
use Illuminate\Support\Facades\Storage;
class NhanVienPDBCLController extends Controller
{
    public function index()
    {
        $nhanviens = NhanVienPDBCL::all();
        return view('nhanvien.index', compact('nhanviens'));
    }

    public function create()
    {
        return view('nhanvien.create');
    }

    public function store(StoreNhanVienRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('anhDaiDien')) {
            $path = $request->file('anhDaiDien')->store('anhDaiDiens', 'public');
            $data['anhDaiDien'] = $path;
        } else {
            $data['anhDaiDien'] = 'anhDaiDiens/anhmacdinh.jpg';
        }

        $data['matKhau'] = bcrypt($data['matKhau']);

        NhanVienPDBCL::create($data);

        return redirect()->route('nhanvien.index')->with('success', 'Thêm nhân viên thành công!');
    }

    public function edit($maNV)
    {
        $nhanvien = NhanVienPDBCL::findOrFail($maNV);
        return view('nhanvien.edit', compact('nhanvien'));
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
