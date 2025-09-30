<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'buyer_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
