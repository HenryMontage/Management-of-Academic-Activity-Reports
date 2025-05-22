<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichBaoCao extends Model
{
    use HasFactory;
    protected $table = 'lich_bao_caos';
    protected $primaryKey = 'maLich';
    public $timestamps = true;
    protected $fillable = ['ngayBaoCao', 'gioBaoCao', 'chuDe', 'giangVienPhuTrach_id', 'hanNgayNop', 'hanGioNop', 'boMon_id'];

    public function giangVienPhuTrach()
    {
        return $this->belongsToMany(GiangVien::class, 'lich_bao_cao_giang_vien', 'lich_bao_cao_id', 'giang_vien_id');
    }

    public function boMon()
    {
        return $this->belongsTo(BoMon::class, 'boMon_id', 'maBoMon');
    }

    public function giangVien()
    {
        return $this->belongsTo(GiangVien::class, 'giangVienPhuTrach_id', 'maGiangVien');
    }

    public function baoCaos() {
        return $this->hasMany(BaoCao::class, 'lich_bao_cao_id');
    }

    public function bienBanBaoCaos()
    {
        return $this->hasMany(BienBanBaoCao::class, 'lichBaoCao_id', 'maLich');
    }

    public function dangKyBaoCaos()
    {
        return $this->hasMany(DangKyBaoCao::class, 'lichBaoCao_id', 'maLich');
    }



}
