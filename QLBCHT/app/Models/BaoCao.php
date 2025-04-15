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
    protected $fillable = ['maBaoCao','tenBaoCao', 'ngayNop', 'dinhDang', 'tomTat', 'duongDanFile', 'giangVien_id'];

    public function giangVien()
    {
        return $this->belongsTo(GiangVien::class, 'giangVien_id', 'maGiangVien');
    }

}
