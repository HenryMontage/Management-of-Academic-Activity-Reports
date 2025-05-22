<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoMon extends Model
{
    use HasFactory;
    protected $table = 'bo_mons';
    protected $primaryKey = 'maBoMon';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    protected $fillable = ['maBoMon', 'tenBoMon', 'maKhoa','truongBoMon'];


    // Bộ môn thuộc về một khoa
    public function khoa()
    {
        return $this->belongsTo(Khoa::class, 'maKhoa', 'maKhoa');
    }

    // Một bộ môn có nhiều giảng viên
    public function giangViens()
    {
        return $this->hasMany(GiangVien::class, 'boMon_id', 'maBoMon');
    }

    public function truong_BoMon()
{
    return $this->belongsTo(GiangVien::class, 'truongBoMon', 'maGiangVien');
}
}
