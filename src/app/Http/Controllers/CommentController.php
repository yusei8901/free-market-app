<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Product;
Use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{

    public function store(CommentRequest $request, Product $item_id)
    {
        $product = $item_id;
        $comment = $product->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);
        return redirect()
            ->route('products.item', ['item_id' => $product->id])
            ->with('comment', $comment);
    }
}
