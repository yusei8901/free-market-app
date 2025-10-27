<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // いいね切り替え
    public function toggle($item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        if ($user->likes()->where('item_id', $item->id)->exists()) {
            // いいね解除
            $user->likes()->detach($item->id);
        } else {
            // いいね追加
            $user->likes()->attach($item->id);
        }
        return back();
    }
}
