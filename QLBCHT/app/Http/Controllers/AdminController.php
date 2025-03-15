<?php

namespace App\Http\Controllers;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Quyen;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
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
    public function update(AdminRequest $request, Admin $admin)
    {
        dd($request->ho);

        // $data = [
        //     'ho' => trim($request->input('ho')), 
        //     'ten' => trim($request->input('ten')),
        //     'sdt' => $request->input('sdt'),
        //     'email' => $request->input('email'),
        //     'quyen_id' => (int) $request->input('quyen_id'),
        // ];
        // if ($request->filled('matKhau')) {
        //     $data['matKhau'] = bcrypt($request->matKhau);
        // }
        // $admin->update($data);
        $admin->update([
            'ho' =>  (string) $request->ho,
            'ten' =>  $request->ten,
            'sdt' => $request->sdt,
            'email' => $request->email,
            'quyen_id' => $request->quyen_id ? (int) $request->quyen_id : null,
            'matKhau' => $request->filled('matKhau') ? bcrypt($request->matKhau) : $admin->matKhau,
        ]);        
        
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
