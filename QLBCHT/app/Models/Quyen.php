<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quyen extends Model
{
    use HasFactory;
    protected $table = 'quyens';
    protected $primaryKey = 'maQuyen';
    protected $fillable = ['tenQuyen', 'nhomRoute'];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'quyen_id', 'maQuyen');
    }

    public function nhanViens()
    {
        return $this->hasMany(NhanVienPDBCL::class, 'quyen_id', 'maQuyen');
    }

    public function chucVus()
    {
        return $this->hasMany(ChucVu::class, 'quyen_id', 'maQuyen');
    }
}
