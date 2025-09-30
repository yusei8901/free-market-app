<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // いいね切り替え
    public function toggle($item_id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($item_id);

        if ($user->likes()->where('product_id', $product->id)->exists()) {
            // いいね解除
            $user->likes()->detach($product->id);
        } else {
            // いいね追加
            $user->likes()->attach($product->id);
        }
        return back();
    }
}
