<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChucVuRequest;
use App\Models\ChucVu;
use App\Models\Quyen;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;



class ChucVuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $chucVus = ChucVu::all();
    //     return view('chucvu.index', compact('chucVus'));
    // }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTable();
        }
        
        return view('chucvu.index');
    }

    private function getDataTable()
    {
        $chucVus = ChucVu::with('quyen');
        
        return DataTables::of($chucVus)
            ->addIndexColumn()
            ->addColumn('quyen', function($chucVu) {
                return $chucVu->quyen ? $chucVu->quyen->tenQuyen : 'Không';
            })
            ->addColumn('hanhdong', function($chucVu) {
                return view('components.action-buttons', [
                    'row' => $chucVu,
                    'editRoute' => 'chucvu.edit',
                    'deleteRoute' => 'chucvu.destroy',
                    'id' => $chucVu->maChucVu
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
        return view('chucvu.create', compact('quyens'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChucVuRequest $request)
    {
        ChucVu::create([
            'tenChucVu' => $request->tenChucVu,
            'quyen_id' => $request->quyen_id ?? null, // Cho phép quyen_id có thể null
        ]);
    
        return redirect()->route('chucvu.index')->with('success', 'Thêm chức vụ thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChucVu $chucVu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($maChucVu)
    {
        $chucvu = ChucVu::findOrFail($maChucVu);
        $quyens = Quyen::all(); // Lấy tất cả quyền để hiển thị trong dropdown
        return view('chucvu.edit', compact('chucvu', 'quyens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChucVuRequest $request, ChucVu $chucvu)
    {
        $chucvu->update([
            'tenChucVu' => $request->tenChucVu,
            'quyen_id' => $request->quyen_id, // Cho phép cập nhật quyền nếu có
        ]);

        return redirect()->route('chucvu.index')->with('success', 'Cập nhật chức vụ thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($maChucVu)
    {
        ChucVu::findOrFail($maChucVu)->delete();
        return redirect()->route('chucvu.index')->with('success', 'Xóa chức vụ thành công!');
    }
}
