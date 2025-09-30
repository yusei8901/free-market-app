<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Comment;

class ProductController extends Controller
{
    // 商品一覧ページ表示
    public function index()
    {
        $products = Product::all();
        $myLists = [];
        if (Auth::check()) {
            $myLists = Auth::user()->likes()->with('categories')->get();
        }
        return view('products.index', compact('products', 'myLists'));
    }

    // 出品登録ページ表示
    public function sell()
    {
        $categories = Category::all();
        return view('products.sell', ['categories' => $categories]);
    }
    // 商品登録機能
    public function store(ExhibitionRequest $request)
    {
        // 画像保存
        $path = $request->file('product_image')->store('products', 'public');
        // 商品作成（ログインユーザー紐づけ）
        $product = Product::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'product_image' => $path,
            'condition' => $request->condition,
            'brand' => $request->brand ?? null,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        // カテゴリー紐づけ
        $product->categories()->attach($request->categories);
        return redirect()->route('mypage');
    }

    // 商品詳細ページ表示
    public function item($product_id)
    {
        $product = Product::with(['categories', 'comments.user'])->findOrFail($product_id);
        return view('products.item', compact('product'));
    }
}
