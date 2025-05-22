<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khoa extends Model
{
    use HasFactory;

    protected $table = 'khoas'; // Đảm bảo đúng tên bảng

    protected $primaryKey = 'maKhoa'; // Đặt maKhoa là khóa chính
    public $incrementing = false; // Vì maKhoa không phải auto-increment
    protected $keyType = 'string'; // Nếu maKhoa là chuỗi 
    public $timestamps = true;
    protected $fillable = ['maKhoa', 'tenKhoa','truongKhoa'];

    protected $casts = [
        'maKhoa' => 'string',
    ];


    // Một khoa có nhiều bộ môn
    public function boMons()
    {
        return $this->hasMany(BoMon::class, 'maKhoa', 'maKhoa');
    }

    public function truong_Khoa()
    {
        return $this->belongsTo(GiangVien::class, 'truongKhoa', 'maGiangVien');
    }  
}
