<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $fillable = [
        'user_type',
        'user_ma',
        'session_id',
        'last_activity',
    ];
}
