<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    use HasFactory;
    protected $table = 'email_settings';
    public $timestamps = true;
    protected $fillable = [
        'mailer',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name',
    ];

    // Nếu bạn muốn chỉ lấy cấu hình đầu tiên
    public static function getActiveConfig()
    {
        return self::first();
    }
}
