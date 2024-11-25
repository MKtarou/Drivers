<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable
{
    use Notifiable;

    public $timestamps = false; // タイムスタンプを無効化
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'group_id', 'u_name', 'u_pass', 'u_goal', 'u_limit'
    ];

    protected $hidden = [
        'u_pass',
    ];
    
}

