<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBudget extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'category_id',
        'price',
        'details',
        'user_id',
        'group_id',
    ];

    // Categoryモデルとのリレーションを定義
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Userモデルとのリレーションを定義
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}

