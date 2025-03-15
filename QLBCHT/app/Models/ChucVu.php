<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChucVu extends Model
{
    use HasFactory;
    protected $table = 'chuc_vus';
    protected $primaryKey = 'maChucVu';
    public $incrementing = true;
    protected $fillable = ['maChucVu', 'tenChucVu', 'quyen_id'];

    // Một chức vụ có nhiều giảng viên
    public function giangViens()
    {
        return $this->hasMany(GiangVien::class, 'chucVu', 'maChucVu');
    }

    // Một chức vụ thuộc về một quyền
    public function quyen()
    {
        return $this->belongsTo(Quyen::class, 'quyen_id', 'maQuyen');
    }
}
