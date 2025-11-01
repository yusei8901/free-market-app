<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name',
        'item_image', 'brand', 'description', 'price', 'condition', 'sold'
    ];
    // ユーザーリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // カテゴリーリレーション
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    // いいねリレーション
    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }
    // コメントリレーション
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    // 購入リレーション
    public function purchases()
    {
        return $this->hasOne(Purchase::class);
    }
    protected $casts = [
        'sold' => 'boolean',
    ];
}
