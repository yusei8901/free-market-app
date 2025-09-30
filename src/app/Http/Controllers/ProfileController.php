<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // マイページ画面表示
    public function index()
    {
        $user = Auth::user();
        $items = $user->products()->latest()->get();
        $purchases = $user->purchases()->with('product')->latest()->get();
        return view('profile.mypage', compact('user', 'items', 'purchases'));
    }
    // プロフィール編集画面表示
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', ['user' => $user]);
    }
    // プロフィール画面の編集・更新機能
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $user->fill($request->only(['name', 'postal_code', 'address', 'building']));
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image && \Storage::disk('public')->exists($user->profile_image)) {
                \Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store('profile', 'public');
            $user->profile_image = $path;
        }
        $user->save();
        return redirect('/mypage');
    }
    // 送付先変更ページ表示
    public function address($item_id)
    {
        $user = Auth::user();
        return view('profile.address', compact('user', 'item_id'));
    }

    // 送付先変更ページ編集機能
    public function addressUpdate(AddressRequest $request)
    {
        $address = $request->only(['postal_code', 'address', 'building']);
        $item_id = $request->item_id;
        $user = Auth::user();
        $user->update($address);
        return redirect()->route('products.purchase', ['item_id' => $item_id]);
    }
}
