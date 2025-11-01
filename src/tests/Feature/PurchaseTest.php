<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test
     * 「購入する」ボタンを押下すると購入が完了する
     */
    public function test_logged_in_user_can_complete_purchase()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'sold' => false,
        ]);
        $response = $this->actingAs($user)
            ->post(route('purchase.store', $item->id), [
                'postal_code' => '123-4567',
                'address' => '東京都渋谷区1-2-3',
                'building' => 'テストマンション101',
                'payment' => 'コンビニ払い',
                'price' => 1000,
            ]);
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
            'building' => 'テストマンション101',
        ]);
    }

    /** @test
     * 購入した商品は商品一覧画面にて「sold」と表示される
     */
    public function test_purchased_item_is_displayed_as_sold_on_item_list()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'sold' => false,
            'name' => 'テスト商品',
        ]);
        $this->actingAs($user)
            ->post(route('purchase.store', $item->id), [
                'postal_code' => '123-4567',
                'address' => '東京都港区1-2-3',
                'building' => 'テストマンション101',
                'payment' => 'カード払い',
                'price' => 1000,
            ]);
        $this->assertTrue($item->fresh()->sold);
        $response = $this->actingAs($user)->get(route('index'));
        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /** @test
     * 「プロフィール/購入した商品一覧」に追加されている
     */
    public function test_purchased_item_is_added_to_profile_purchased_list()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'sold' => false,
            'name' => 'テスト商品A',
        ]);
        $this->actingAs($user)
            ->post(route('purchase.store', $item->id), [
                'postal_code' => '123-4567',
                'address' => '東京都渋谷区1-2-3',
                'building' => 'テストマンション101',
                'payment' => 'カード払い',
                'price' => 1000,
            ]);
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $response = $this->actingAs($user)->get('/mypage?page=buy');
        $response->assertStatus(200);
        $response->assertSee('テスト商品A');
    }
}
