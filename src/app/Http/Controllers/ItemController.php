<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Comment;

class ItemController extends Controller
{
    // 商品一覧ページ表示
    public function index()
    {
        $items = Item::when(Auth::check(), function ($query) {
            $query->where(function ($q) {
                $q->where('user_id', '!=', Auth::id())
                    ->orWhereNull('user_id');
            });
        })->get();
        $myLists = [];
        if (Auth::check()) {
            $myLists = Auth::user()->likes()->with('categories')->get();
        }
        return view('items.index', compact('items', 'myLists'));
    }

    // 出品登録ページ表示
    public function sell()
    {
        $categories = Category::all();
        return view('items.sell', ['categories' => $categories]);
    }
    // 商品登録機能
    public function store(ExhibitionRequest $request)
    {
        // 画像保存
        $path = $request->file('item_image')->store('items', 'public');
        // 商品作成（ログインユーザー紐づけ）
        $item = Item::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'item_image' => $path,
            'condition' => $request->condition,
            'brand' => $request->brand ?? null,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        // カテゴリー紐づけ
        $item->categories()->attach($request->categories);
        return redirect()->route('mypage');
    }

    // 商品詳細ページ表示
    public function item($item_id)
    {
        $item = Item::with(['categories', 'comments.user'])->findOrFail($item_id);
        return view('items.item', compact('item'));
    }

    // 検索機能
    public function search(Request $request)
    {
        $user = Auth::user();
        $keyword = $request->input('keyword');
        $items = Item::where('name', 'LIKE', "%{$keyword}%")->get();
        $likedItems = collect();
        if($user) {
            $likedItems = $user->likes()->where('name', 'LIKE', "%{$keyword}%")->get();
        }
        return view('items.result', compact('items', 'keyword', 'likedItems'));
    }
}
