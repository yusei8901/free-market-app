<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    /** @test
     * 必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）
     */
    public function test_mypage_displays_profile_and_items_correctly()
    {
        // ==== テストデータ作成 ====
        // ユーザー作成
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'profiles/test_user.jpg',
        ]);
        // 他ユーザー
        $otherUser = User::factory()->create();
        // 出品商品（ログインユーザーが出品した商品）
        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品A',
            'item_image' => 'items/sell_item.jpg',
        ]);
        // 他人が出品した商品を購入
        $buyItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'name' => '購入商品B',
            'item_image' => 'items/buy_item.jpg',
            'sold' => true,
        ]);
        // 購入情報を登録
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $buyItem->id,
        ]);
        // ==== アクセス ====
        $response = $this->actingAs($user)->get('/mypage');
        // ==== 検証 ====
        // ステータスコード
        $response->assertStatus(200);
        // ユーザー情報が表示されていること
        $response->assertSee($user->name);
        $response->assertSee('storage/' . $user->profile_image);
        // 出品商品が表示されていること
        $response->assertSee($sellItem->name);
        $response->assertSee('storage/' . $sellItem->item_image);
        // 購入商品が表示されていること
        $response->assertSee($buyItem->name);
        $response->assertSee('storage/' . $buyItem->item_image);
    }
}
