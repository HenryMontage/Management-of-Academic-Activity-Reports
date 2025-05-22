<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DangKyBaoCao extends Model
{
    use HasFactory;
    protected $table = 'dang_ky_bao_caos';
    protected $primaryKey = 'maDangKyBaoCao';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = ['maDangKyBaoCao','ngayDangKy', 'trangThai', 'lichBaoCao_id','giangVien_id', 'baoCao_id', 'ketQuaGopY'];
    public function baoCaos()
    {
        return $this->belongsToMany(BaoCao::class, 'bao_cao_dang_ky_bao_caos', 'maDangKyBaoCao', 'maBaoCao');
    }

    public function lichBaoCao()
    {
        return $this->belongsTo(LichBaoCao::class, 'lichBaoCao_id', 'maLich');
    }

    public function giangVien()
    {
        return $this->belongsTo(GiangVien::class, 'giangVien_id', 'maGiangVien');
    }


}


