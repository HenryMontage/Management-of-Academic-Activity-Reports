<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BienBanBaoCao extends Model
{
    use HasFactory;
    protected $table = 'bien_ban_bao_caos';
    protected $primaryKey = 'maBienBan';
    protected $fillable = ['ngayNop', 'fileBienBan', 'lichBaoCao_id', 'trangThai', 'nhanVien_id'];
}
