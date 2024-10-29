<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Category;
use App\Models\User;

class HomeBudget extends Model
{
    use HasFactory;

    protected $table = 'home_budgets';

    protected $fillable = [
        'date',
        'gruop_id',
        'user_id',
        'category_id',
        'price'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d'
    ];

    public function category() : Relation {
        return $this->belongsTo(Category::class);
    }

    public function user()  // Userモデルとのリレーションを追加
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
