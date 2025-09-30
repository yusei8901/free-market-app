<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'postal_code',
        'address',
        'building',
    ];

    // 商品リレーション
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    // 良いねリレーション
    public function likes()
    {
        return $this->belongsToMany(Product::class, 'likes')->withTimestamps();
    }
    // コメントリレーション
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'buyer_id');
    }


    public function purchasedProducts()
    {
        return $this->belongsToMany(Product::class, 'purchases', 'buyer_id', 'product_id')->withTimestamps();
    }

    public function getFormattedPostalCode()
    {
        return substr($this->postal_code, 0, 3) . '-' . substr($this->postal_code, 3);
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
    ];
}
