<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Tests\TestCase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function all_items_are_displayed()
    {
        // 商品を3つ作成
        Item::factory()->count(3)->create();
        // 商品ページを開く
        $response = $this->get('/');
        // ステータス200 & 商品が3つとも表示されているか確認
        $response->assertStatus(200);
        foreach (Item::all() as $item) {
            $response->assertSee($item->name);
        }
    }

    /** @test */
    public function sold_items_display_sold_label()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        // 購入済み（purchasesテーブルに登録）
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $this->post('/purchase/{item_id}');
        $response = $this->get('/');
        // 「Sold」ラベルが表示されているか確認
        $response->assertSee('Sold');
    }

    /** @test */
    public function user_own_items_are_not_displayed_in_list()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        // 自分の商品と他人の商品を作成
        $myItem = Item::factory()->create(['user_id' => $user->id]);
        $otherItem = Item::factory()->create(['user_id' => $otherUser->id]);

        // ログイン状態で一覧取得
        $response = $this->actingAs($user)->get('/');

        // 自分の商品は表示されない
        $response->assertDontSee($myItem->name);
        // 他人の商品は表示される
        $response->assertSee($otherItem->name);
    }
}
