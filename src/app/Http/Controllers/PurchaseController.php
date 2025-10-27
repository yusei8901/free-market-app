<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    // 購入画面表示
    public function index($item_id)
    {
        $item = Item::find($item_id);
        $user = Auth::user();
        return view('items.purchase', compact('user', 'item'));
    }

    // 購入直前画面表示
    public function confirm(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $requests = $request->only(['price', 'payment', 'postal_code', 'address', 'building']);
        return view('items.confirm', compact('item', 'requests'));
    }

    // 購入処理
    public function store(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        // 購入情報の登録
        Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'payment' => $request->payment,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);
        // 商品をSOLDに更新
        $item->update(['sold' => true]);
        return redirect()->route('index')->with('purchase_success', '購入が完了しました。');
    }
}
