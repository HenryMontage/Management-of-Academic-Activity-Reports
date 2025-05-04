<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\GiangVien;
class KiemTraQuyen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //  $user = auth()->user(); 
         $guard = session('current_guard');
        $user = Auth::guard($guard)->user(); 
        $gv = GiangVien::with('chucVuObj.quyen')->find($user->maGiangVien);
        $quyen = $user->quyen ?? $user->chucVu->quyen ?? null;
        $dsQuyen =  $user->quyen?->nhomRoute ??  $gv->chucVuObj?->quyen?->nhomRoute ?? [];
       
        view()->share('current_quyen', $quyen);

        if (!$dsQuyen) {
            abort(403, 'Không có quyền truy cập');
        }
        // Các route luôn cho phép truy cập
        $freeRoutes = ['admin.dashboard','email-settings.index', 'email-settings.edit', 'email-settings.update','email-settings.test','email-settings.form','email-settings.save'];

        $routeName = $request->route()->getName();
        if (in_array($routeName, $freeRoutes)) {
            return $next($request);
        }

        $routePrefix = explode('.', $request->route()->getName())[0];

        // if (!in_array($routePrefix, $quyen->nhomRoute ?? [])) {
        //     abort(403, 'Không có quyền truy cập trang này');
        // }
        if (!in_array($routePrefix, $dsQuyen?? [])) {
            abort(403, 'Không có quyền truy cập trang này');
        }

        return $next($request);
    }
}
