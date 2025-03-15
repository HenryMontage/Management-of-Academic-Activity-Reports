<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichBaoCao extends Model
{
    use HasFactory;
    protected $table = 'lich_bao_caos';
    protected $primaryKey = 'maLich';
    protected $fillable = ['ngayBaoCao', 'gioBaoCao', 'chuDe', 'giangVienPhuTrach_id', 'hanNgayNop', 'hanGioNop', 'boMon_id'];
}
