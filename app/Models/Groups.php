<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;

    public $timestamps = false; // タイムスタンプを無効化
    protected $table = 'groups'; // テーブル名を指定
    protected $primaryKey = 'group_id'; // 主キーを明示

    // Mass Assignmentを許可するカラムを指定
    protected $fillable = [
        'g_name', 
        'g_limit', 
        'g_goal'
    ];
}
