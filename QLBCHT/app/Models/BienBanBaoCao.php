<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BienBanBaoCao extends Model
{
    use HasFactory;
    protected $table = 'bien_ban_bao_caos';
    protected $primaryKey = 'maBienBan';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = true;  
    protected $fillable = ['maBienBan','ngayNop', 'fileBienBan', 'lichBaoCao_id', 'trangThai', 'nhanVien_id','giangVien_id'];
    public function lichBaoCao()
    {
        return $this->belongsTo(LichBaoCao::class, 'lichBaoCao_id', 'maLich');
    }
 
    // public function nhanVien()
    // {
    //     return $this->belongsTo(NhanVienPDBCL::class, 'nhanVien_id', 'maNV');
    // }

    public function giangVien()
    {
        return $this->belongsTo(GiangVien::class, 'giangVien_id', 'maGiangVien');
    }

}
