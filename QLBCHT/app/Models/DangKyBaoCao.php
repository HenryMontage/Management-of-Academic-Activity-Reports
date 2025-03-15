<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DangKyBaoCao extends Model
{
    use HasFactory;
    protected $table = 'dang_ky_bao_caos';
    protected $primaryKey = 'maDangKyBaoCao';
    protected $fillable = ['ngayDangKy', 'trangThai', 'lichBaoCao_id', 'baoCao_id', 'ketQuaGopY'];
}
