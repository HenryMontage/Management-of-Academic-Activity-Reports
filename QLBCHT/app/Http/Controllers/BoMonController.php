<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoMonRequest;
use App\Models\BoMon;
use App\Models\Khoa;
use App\Models\GiangVien;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BoMonController extends Controller
{


    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTable();
        }
        return view('bomon.index');
    }

    private function getDataTable()
    {
        $data = BoMon::with(['khoa', 'truong_BoMon']);
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('ho_ten_truong_bomon', function($bomon) {
                return optional($bomon->truong_BoMon)->ho ? $bomon->truong_BoMon->ho . ' ' . $bomon->truong_BoMon->ten : 'Không';
            })
            ->addColumn('khoa', function ($row) {
                return $row->khoa ? $row->khoa->tenKhoa : 'Không';
            })
            ->addColumn('hanhdong', function($bomon) {
                return view('components.action-buttons', [
                    'row' => $bomon,
                    'editRoute' => 'bomon.edit',
                    'deleteRoute' => 'bomon.destroy',
                    'id' => $bomon->maBoMon
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
        $khoas = Khoa::all();
        $giangviens = GiangVien::all();
        return view('bomon.create', compact('khoas', 'giangviens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BoMonRequest $request)
    {
        BoMon::create([
            'maBoMon' => $request->maBoMon,
            'tenBoMon' => $request->tenBoMon,
            'maKhoa' => $request->maKhoa,
            'truongBoMon' => $request->truongBoMon,
        ]);

        return redirect()->route('bomon.index')->with('success', 'Thêm Bộ Môn thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BoMon $boMon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BoMon $bomon)
    {
        $khoas = Khoa::all();
    $giangviens = GiangVien::all();
    return view('bomon.edit', compact('bomon', 'khoas', 'giangviens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BoMonRequest $request, BoMon $bomon)
    {
        $bomon->update([
            'tenBoMon' => $request->tenBoMon,
            'maKhoa' => $request->maKhoa,
            'truongBoMon' => $request->truongBoMon,
        ]);

        return redirect()->route('bomon.index')->with('success', 'Cập nhật Bộ Môn thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BoMon $bomon)
    {
        $bomon->delete();
        return redirect()->route('bomon.index')->with('success', 'Xóa Bộ Môn thành công!');
    }
}
