<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KhoaController;
use App\Http\Controllers\BoMonController;
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\GiangVienController;
use App\Http\Controllers\NhanVienPDBCLController;
use App\Http\Controllers\LichBaoCaoController;
use App\Http\Controllers\BaoCaoController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('auth.login');


Route::middleware(['auth:admins', 'session.timeout'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
  //Routes CRUD Admin
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index'); // Danh sách Admin
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create'); // Form thêm
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store'); // Lưu Admin mới
        Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('admin.edit'); // Form sửa
        Route::put('/{admin}', [AdminController::class, 'update'])->name('admin.update'); // Cập nhật Admin
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('admin.destroy'); // Xóa Admin
    });

    Route::prefix('giangvien')->group(function () {
        Route::get('/', [GiangVienController::class, 'index'])->name('giangvien.index');
        Route::get('/create', [GiangVienController::class, 'create'])->name('giangvien.create');
        Route::post('/store', [GiangVienController::class, 'store'])->name('giangvien.store');
        Route::get('/{maGiangVien}/edit', [GiangVienController::class, 'edit'])->name('giangvien.edit');
        Route::put('/{maGiangVien}', [GiangVienController::class, 'update'])->name('giangvien.update');
        Route::delete('/{maGiangVien}', [GiangVienController::class, 'destroy'])->name('giangvien.destroy');
    });
    
    // Routes CRUD Khoa
    Route::prefix('khoa')->group(function () {
        Route::get('/', [KhoaController::class, 'index'])->name('khoa.index'); 
        Route::get('/create', [KhoaController::class, 'create'])->name('khoa.create'); 
        Route::post('/store', [KhoaController::class, 'store'])->name('khoa.store'); 
        Route::get('/{khoa}/edit', [KhoaController::class, 'edit'])->name('khoa.edit'); 
        Route::put('/{khoa}', [KhoaController::class, 'update'])->name('khoa.update'); 
        Route::delete('/{khoa}', [KhoaController::class, 'destroy'])->name('khoa.destroy'); 
    });
    
    // Routes CRUD Chuc Vu
    Route::prefix('chucvu')->group(function () {
        Route::get('/', [ChucVuController::class, 'index'])->name('chucvu.index');
        Route::get('/create', [ChucVuController::class, 'create'])->name('chucvu.create');
        Route::post('/store', [ChucVuController::class, 'store'])->name('chucvu.store');
        Route::get('/{chucvu}/edit', [ChucVuController::class, 'edit'])->name('chucvu.edit');
        Route::put('/{chucvu}', [ChucVuController::class, 'update'])->name('chucvu.update');
        Route::delete('/{chucvu}', [ChucVuController::class, 'destroy'])->name('chucvu.destroy');
    });
    
    // Routes CRUD Bo Mon
    Route::prefix('bomon')->group(function () {
        Route::get('/', [BoMonController::class, 'index'])->name('bomon.index'); // Danh sách bộ môn
        Route::get('/create', [BoMonController::class, 'create'])->name('bomon.create'); // Form thêm bộ môn
        Route::post('/store', [BoMonController::class, 'store'])->name('bomon.store'); // Lưu bộ môn mới
        Route::get('/{bomon}/edit', [BoMonController::class, 'edit'])->name('bomon.edit'); // Form sửa bộ môn
        Route::put('/{bomon}', [BoMonController::class, 'update'])->name('bomon.update'); // Cập nhật bộ môn
        Route::delete('/{bomon}', [BoMonController::class, 'destroy'])->name('bomon.destroy'); // Xóa bộ môn
    });
});

Route::middleware(['giangvien_or_nhanvien', 'session.timeout'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth:giang_viens', 'session.timeout'])->group(function () {    
   
    Route::prefix('lichbaocao')->group(function () {
        Route::get('/', [LichBaoCaoController::class, 'index'])->name('lichbaocao.index');
        Route::get('/create', [LichBaoCaoController::class, 'create'])->name('lichbaocao.create');
        Route::post('/store', [LichBaoCaoController::class, 'store'])->name('lichbaocao.store');
        Route::get('/{lichbaocao}/edit', [LichBaoCaoController::class, 'edit'])->name('lichbaocao.edit');
        Route::put('/{lichbaocao}', [LichBaoCaoController::class, 'update'])->name('lichbaocao.update');
        Route::delete('/{lichbaocao}', [LichBaoCaoController::class, 'destroy'])->name('lichbaocao.destroy');
        Route::get('/giangviens/{boMon_id}', [LichBaoCaoController::class, 'getGiangVien'])->name('lichbaocao.getGiangVien');// api lấy giảng viên từ bộ môn

    });

    Route::prefix('quan-ly-bao-cao')->group(function () {
        Route::get('/', [BaoCaoController::class, 'index'])->name('baocao.index'); // Xem danh sách báo cáo
        Route::get('/create', [BaoCaoController::class, 'create'])->name('baocao.create'); // Trang tạo báo cáo mới
        Route::post('/', [BaoCaoController::class, 'store'])->name('baocao.store'); // Lưu báo cáo mới
        Route::get('/{maBaoCao}/edit', [BaoCaoController::class, 'edit'])->name('baocao.edit'); // Trang chỉnh sửa báo cáo
        Route::put('/{maBaoCao}', [BaoCaoController::class, 'update'])->name('baocao.update'); // Cập nhật báo cáo
        Route::delete('/{maBaoCao}', [BaoCaoController::class, 'destroy'])->name('baocao.destroy'); // Xóa báo cáo
    });
    

});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', function () {
    if (Auth::guard('admins')->check()) {
        Auth::guard('admins')->logout();
    } elseif (Auth::guard('giang_viens')->check()) {
        Auth::guard('giang_viens')->logout();
    } elseif (Auth::guard('nhan_vien_p_d_b_c_ls')->check()) {
        Auth::guard('nhan_vien_p_d_b_c_ls')->logout();
    }

    Session::flush();
    return redirect()->route('login');
})->name('logout');






// Route::resource('giangvien', GiangVienController::class);



// // Trang chủ chuyển hướng tùy theo loại người dùng
// Route::get('/', function () {
//     if (auth()->check()) {
//         $user = auth()->user();
//         if ($user instanceof \App\Models\Admin) {
//             return redirect()->route('admin.dashboard');
//         }
//         return redirect()->route('user.dashboard');
//     }
//     return redirect()->route('login');
// });

// // Authentication routes
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// // Admin dashboard
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('admin.dashboard');

//     Route::prefix('admin')->group(function () {
//         Route::get('/', [AdminController::class, 'index'])->name('admin.index');
//         Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
//         Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
//         Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('admin.edit');
//         Route::put('/{admin}', [AdminController::class, 'update'])->name('admin.update');
//         Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('admin.destroy');
//     });
// });

// // User dashboard (giảng viên + nhân viên phòng đảm bảo chất lượng)
// Route::middleware(['auth', 'user'])->group(function () {
//     Route::get('/user/dashboard', function () {
//         return view('user.dashboard');
//     })->name('user.dashboard');

//     // Giảng viên routes
//     Route::prefix('giangvien')->group(function () {
//         Route::get('/', [GiangVienController::class, 'index'])->name('giangvien.index');
//         Route::get('/create', [GiangVienController::class, 'create'])->name('giangvien.create');
//         Route::post('/store', [GiangVienController::class, 'store'])->name('giangvien.store');
//         Route::get('/{maGiangVien}/edit', [GiangVienController::class, 'edit'])->name('giangvien.edit');
//         Route::put('/{maGiangVien}', [GiangVienController::class, 'update'])->name('giangvien.update');
//         Route::delete('/{maGiangVien}', [GiangVienController::class, 'destroy'])->name('giangvien.destroy');
//     });

//     // Nhân viên phòng ĐBCL routes
//     // Route::prefix('nhanvienpdbcl')->group(function () {
//     //     Route::get('/', [NhanVienPDBCLController::class, 'index'])->name('nhanvienpdbcl.index');
//     //     Route::get('/create', [NhanVienPDBCLController::class, 'create'])->name('nhanvienpdbcl.create');
//     //     Route::post('/store', [NhanVienPDBCLController::class, 'store'])->name('nhanvienpdbcl.store');
//     //     Route::get('/{maNV}/edit', [NhanVienPDBCLController::class, 'edit'])->name('nhanvienpdbcl.edit');
//     //     Route::put('/{maNV}', [NhanVienPDBCLController::class, 'update'])->name('nhanvienpdbcl.update');
//     //     Route::delete('/{maNV}', [NhanVienPDBCLController::class, 'destroy'])->name('nhanvienpdbcl.destroy');
//     // });
// });