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
    protected $fillable = ['ho', 'ten', 'sdt', 'email', 'matKhau', 'quyen_id'];


    public function getAuthPassword()
    {
        return $this->matKhau; // Laravel sẽ dùng trường này để check password
    }
}
