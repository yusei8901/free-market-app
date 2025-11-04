<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentSelectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test
     * 小計画面で変更が反映される
     */
    public function test_selected_payment_method_is_reflected_on_confirm_page()
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区道玄坂1-2-3',
            'building' => '渋谷ビル301'
        ]);
        $item = Item::factory()->create([
            'price' => 5000,
        ]);
        $this->actingAs($user);

        // 支払い方法を選択して「購入成功画面」を表示
        $response = $this->get(route('items.index', [
            'item_id' => $item->id,
            'price' => $item->price,
            'payment_method' => 'card',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]));
        // ステータスコードが200であることを確認
        $response->assertStatus(200);
        // 選択した支払い方法「カード支払い」が表示されていることを確認
        $response->assertSee('カード支払い');
    }
}
