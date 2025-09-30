<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    // 購入画面表示
    public function purchase($item_id)
    {
        $product = Product::find($item_id);
        $user = Auth::user();
        return view('products.purchase', compact('user', 'product'));
    }

    public function buy(Request $request, Product $product)
    {
        if ($product->sold) {
            return back()->withErrors('すでに購入済みです');
        }

        // 決済処理はここに入れる（省略）
        Purchase::create([
            'buyer_id' => Auth::id(),
            'product_id' => $product->id,
            'price' => $product->price,
        ]);
        $product->update(['sold' => true]);
        return redirect()->route('products.show', $product)->with('success', '購入しました');
    }
}
