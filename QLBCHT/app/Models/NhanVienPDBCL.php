<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhanVienPDBCL extends Model
{
    use HasFactory;
    protected $table = 'nhan_vien_p_d_b_c_ls';
    protected $primaryKey = 'maNV';
    protected $fillable = ['ho', 'ten', 'sdt', 'email', 'matKhau', 'quyen_id'];
}
