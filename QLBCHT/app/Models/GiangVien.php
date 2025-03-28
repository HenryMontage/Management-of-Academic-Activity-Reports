<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiangVien extends Model
{
    use HasFactory;
    protected $table = 'giang_viens';
    protected $primaryKey = 'maGiangVien';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    protected $fillable = ['maGiangVien', 'ho', 'ten', 'email', 'sdt', 'matKhau', 'chucVu', 'boMon_id','anhDaiDien'];
    
    protected $hidden = ['matKhau'];

    public function getAuthPassword()
    {
        return $this->matKhau;
    }
    
    public function chucVu()
    {
        return $this->belongsTo(ChucVu::class, 'chucVu', 'maChucVu');
    }
    public function boMon()
    {
        return $this->belongsTo(BoMon::class, 'boMon_id', 'maBoMon');
    }

    public function lichBaoCaos()
{
    return $this->belongsToMany(LichBaoCao::class, 'lich_bao_cao_giang_vien', 'giang_vien_id', 'lich_bao_cao_id');
}



    public function getRouteKeyName()
    {
        return 'maGiangVien';
    }  
}
