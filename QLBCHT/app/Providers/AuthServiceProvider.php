<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\NhanVienPDBCL;

use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('access-giangvien', function ($user) {
            return auth()->guard('giang_viens')->check();
        });
    
        Gate::define('access-nhanvien', function ($user) {
            return auth()->guard('nhan_vien_p_d_b_c_ls')->check();
        });
    
        Gate::define('view-dangkybaocao', function ($user) {
            return in_array($user->chucVu, [3, 4]);
        });
    }
}
