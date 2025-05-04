<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class NhanVienPDBCL extends Authenticatable
{
    use HasFactory;
    protected $table = 'nhan_vien_p_d_b_c_ls';
    protected $primaryKey = 'maNV';

    public $incrementing = false;
    protected $keyType = 'string';
   
    public $timestamps = true;
    protected $attributes = [
        'matKhau' => null,
    ];
    
    public function setMatKhauAttribute($value)
    {
        $this->attributes['matKhau'] = $value;
    }
    
    protected $hidden = ['matKhau'];
    protected $fillable = ['maNV','ho', 'ten', 'sdt', 'email', 'matKhau','anhDaiDien','quyen_id'];
    public function quyen()
    {
        return $this->belongsTo(Quyen::class, 'quyen_id', 'maQuyen');
    }

    public function getAuthPassword()
    {
        return $this->matKhau; // Laravel sẽ dùng trường này để check password
    }

    public function bienBanBaoCaos()
    {
        return $this->hasMany(BienBanBaoCao::class, 'nhanVien_id', 'maNV');
    }

    
}
