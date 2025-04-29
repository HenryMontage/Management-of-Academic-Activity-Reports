<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaoCao extends Model
{
    use HasFactory;
    protected $table = 'bao_caos';
    protected $primaryKey = 'maBaoCao';
    public $incrementing = true;
    protected $fillable = ['maBaoCao','tenBaoCao', 'ngayNop', 'dinhDang', 'tomTat', 'duongDanFile', 'giangVien_id','lich_bao_cao_id'];

    public function giangVien()
    {
        return $this->belongsTo(GiangVien::class, 'giangVien_id', 'maGiangVien');
    }

    public function lichBaoCao() {
        return $this->belongsTo(LichBaoCao::class, 'lich_bao_cao_id');
    }

    public function dangKyBaoCaos()
    {
        return $this->belongsToMany(DangKyBaoCao::class, 'bao_cao_dang_ky_bao_caos', 'maBaoCao', 'maDangKyBaoCao');
    }


}
