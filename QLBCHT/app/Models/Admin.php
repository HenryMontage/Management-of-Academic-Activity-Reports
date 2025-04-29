<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'admins';  
    protected $primaryKey = 'maAdmin';  // Đặt maAdmin làm khóa chính

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = true;  

    protected $fillable = ['maAdmin', 'ho', 'ten', 'sdt', 'email', 'matKhau', 'quyen_id'];
    public function quyen()
    {
        return $this->belongsTo(Quyen::class, 'quyen_id', 'maQuyen');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getAuthPassword()
    {
        return $this->matKhau; // Laravel sẽ dùng trường này để check password
    }
}
