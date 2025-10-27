<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Item;
Use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{

    public function store(CommentRequest $request, Item $item_id)
    {
        $item = $item_id;
        $comment = $item->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);
        return redirect()
            ->route('items.item', ['item_id' => $item->id])
            ->with('comment', $comment);
    }
}
