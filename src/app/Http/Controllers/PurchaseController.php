<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

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
    // public function confirm(PurchaseRequest $request, $item_id)
    // {
    //     $item = Item::findOrFail($item_id);
    //     $requests = $request->only(['price', 'payment', 'postal_code', 'address', 'building']);
    //     return view('items.confirm', compact('item', 'requests'));
    // }

    // 購入処理（ボタンのみ）
    // public function store(Request $request, $item_id)
    // {
    //     $item = Item::findOrFail($item_id);
    //     // 購入情報の登録
    //     Purchase::create([
    //         'user_id' => Auth::id(),
    //         'item_id' => $item->id,
    //         'payment_method' => $request->payment_method,
    //         'postal_code' => $request->postal_code,
    //         'address' => $request->address,
    //         'building' => $request->building,
    //     ]);
    //     // 商品をSOLDに更新
    //     $item->update(['sold' => true]);
    //     return redirect()->route('index')->with('purchase_success', '購入が完了しました。');
    // }

    // Stripe決済処理
    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        Stripe::setApiKey(config('services.stripe.secret'));
        // 支払い方法を判定
        $payment_method_types = $request->payment_method === 'card' ? ['card'] : ['konbini'];
        // Checkoutセッション作成
        $session = Session::create([
            'payment_method_types' => $payment_method_types,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => $item->name],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('purchase.cancel'),
            'metadata' => [
                'user_id' => auth()->id(),
                'item_id' => $item_id,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building ?? '',
                'payment_method' => $request->payment_method,
            ],
        ]);
        return redirect($session->url);
    }

    // 成功時
    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $session = Session::retrieve($request->get('session_id'));
        $metadata = $session->metadata;
        $item = Item::findOrFail($metadata->item_id);
        // 購入情報登録
        $purchase = Purchase::firstOrCreate([
            'user_id' => $metadata->user_id,
            'item_id' => $metadata->item_id,
        ], [
            'postal_code' => $metadata->postal_code,
            'address' => $metadata->address,
            'building' => $metadata->building,
            'payment_method' => $metadata->payment_method,
        ]);
        // 商品をSOLDに更新
        $item->update(['sold' => true]);
        return view('items.success', compact('item', 'purchase'));
    }

    // キャンセル時
    public function cancel()
    {
        return view('items.cancel');
    }

}
