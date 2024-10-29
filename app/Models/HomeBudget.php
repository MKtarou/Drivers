<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBudget extends Model
{
    use HasFactory;

    // Categoryモデルとのリレーションを定義
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Userモデルとのリレーションを定義
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

