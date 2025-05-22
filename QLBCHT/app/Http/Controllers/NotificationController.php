<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{

//    public function index()
// {
//     if (Auth::guard('giang_viens')->check()) {
//         $user = Auth::guard('giang_viens')->user();

//         switch ($user->chucVuObj->maChucVu) {
//             case 'GV':
//                 $notifications = Notification::where('loai', 'lich')
//                     ->where('daDoc', false)
//                     ->where('doiTuong', 'giang_vien')
//                     ->get();
//                 break;

//             case 'TBM':
//             case 'TK':
//                 $notifications = Notification::whereIn('loai', ['xac_nhan_phieu', 'xac_nhan_bien_ban'])
//                     ->where('daDoc', false)->get();
//                 break;

//             default:
//                 $notifications = collect();
//                 break;
//         }
//     } elseif (Auth::guard('nhan_vien_p_d_b_c_ls')->check()) {
//         $notifications = Notification::whereIn('loai', ['lich','bien_ban', 'phieu_dang_ky'])
//             ->where('daDoc', false)
//             ->where('doiTuong', 'nhan_vien')
//             ->get();
//     } else {
//         $notifications = collect();
//     }

//     // Gộp nội dung
//     $grouped = $notifications->groupBy('noiDung')->map(function ($group, $noiDung) {
//         $first = $group->first();
//         $count = $group->count();
//         return [
//             'noiDung' => $count > 1 ? "Có {$count} " . strtolower($noiDung) : $noiDung,
//             'link' => $first->link,
//         ];
//     })->values();

//     return response()->json($grouped);
// }


//     public function markAllAsRead()
// {
//     if (auth()->guard('giang_viens')->check()) {
//         $user = auth()->guard('giang_viens')->user();

//        switch ($user->chucVuObj->maChucVu) {
//             case 'GV':
//                 Notification::where('loai', 'lich')
//                     ->where('doiTuong', 'giang_vien')
//                     ->update(['daDoc' => true]);
//                 break;

//             case 'TBM':
//             case 'TK':
//                 Notification::whereIn('loai', ['xac_nhan_phieu', 'xac_nhan_bien_ban'])
//                     ->update(['daDoc' => true]);
//                 break;
//         }
//     } elseif (auth()->guard('nhan_vien_p_d_b_c_ls')->check()) {
//         Notification::whereIn('loai', ['lich', 'bien_ban', 'phieu_dang_ky'])
//             ->where('doiTuong', 'nhan_vien')
//             ->update(['daDoc' => true]);
//     }

//     return response()->json(['message' => 'Đã đánh dấu đã đọc']);
// }

public function index()
{
    if (Auth::guard('giang_viens')->check()) {
        $user = Auth::guard('giang_viens')->user();

        switch ($user->chucVuObj->maChucVu) {
            case 'GV':
                $notifications = Notification::where('loai', 'lich')
                    ->where('doiTuong', 'giang_vien')
                    ->latest()->get();
                break;

            case 'TBM':
            case 'TK':
                $notifications = Notification::whereIn('loai', ['xac_nhan_phieu', 'xac_nhan_bien_ban'])
                    ->latest()->get();
                break;

            default:
                $notifications = collect();
                break;
        }
    } elseif (Auth::guard('nhan_vien_p_d_b_c_ls')->check()) {
        $notifications = Notification::whereIn('loai', ['lich','bien_ban', 'phieu_dang_ky'])
        ->where('doiTuong', 'nhan_vien')    
        ->latest()->get();
    } else {
        $notifications = collect();
    }


    return response()->json($notifications);
}

public function markAllAsRead()
{
    if (auth()->guard('giang_viens')->check()) {
        $user = auth()->guard('giang_viens')->user();

        switch ($user->chucVuObj->maChucVu) {
            case 'GV':
                Notification::where('loai', 'lich')
                    ->where('doiTuong', 'giang_vien')
                    ->update(['daDoc' => true]);
                break;

            case 'TBM':
            case 'TK':
                Notification::whereIn('loai', ['xac_nhan_phieu', 'xac_nhan_bien_ban'])
                    ->update(['daDoc' => true]);
                break;
        }
    } elseif (auth()->guard('nhan_vien_p_d_b_c_ls')->check()) {
        Notification::whereIn('loai', ['lich', 'bien_ban', 'phieu_dang_ky'])
            ->where('doiTuong', 'nhan_vien')
            ->update(['daDoc' => true]);
    }

    return response()->json(['message' => 'Đã đánh dấu đã đọc']);
}

public function delete(Request $request)
{
    Notification::where('id', $request->id)->delete();
    return response()->json(['message' => 'Đã xóa']);
}


}
