<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test
     * 送付先住所変更画面にて登録した住所が商品購入画面に反映されている
     */
    public function test_updated_address_is_reflected_on_purchase_page()
    {
        $user = User::factory()->create([
            'postal_code' => '111-1111',
            'address' => '東京都渋谷区初台1-1-1',
            'building' => '旧マンション101'
        ]);
        $item = Item::factory()->create();
        $this->actingAs($user);
        $newData = [
            'postal_code' => '222-2222',
            'address' => '東京都新宿区西新宿2-2-2',
            'building' => '新マンション202',
        ];
        $this->post(route('address.update', ['item_id' => $item->id]), $newData);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'postal_code' => '222-2222',
            'address' => '東京都新宿区西新宿2-2-2',
            'building' => '新マンション202',
        ]);
        $response = $this->get(route('items.index', ['item_id' => $item->id]));
        $response->assertStatus(200)
            ->assertSee('〒222-2222')
            ->assertSee('東京都新宿区西新宿2-2-2')
            ->assertSee('新マンション202');
    }

    /** @test
     * 送付先住所変更画面にて郵便番号の形式を間違えるとバリエーションメッセージが表示される
     */
    public function test_validation_message_is_displayed_when_postal_code_format_is_invalid()
    {
        $user = User::factory()->create([
            'postal_code' => '111-1111',
            'address' => '東京都渋谷区初台1-1-1',
            'building' => '旧マンション101'
        ]);
        $item = Item::factory()->create();
        $this->actingAs($user);
        $newData = [
            'postal_code' => '2222222',
            'address' => '東京都新宿区西新宿2-2-2',
            'building' => '新マンション202',
        ];
        $this->post(route('address.update', ['item_id' => $item->id]), $newData);
        $errors = session('errors')->getMessages();
        $this->assertEquals('郵便番号はハイフンを含めた半角８文字で入力してください', $errors['postal_code'][0]);
    }

    /** @test
     * 購入した商品に送付先住所が紐づいて登録される
     */
    public function test_purchased_item_has_correct_shipping_address()
    {
        $user = User::factory()->create([
            'postal_code' => '111-1111',
            'address' => '東京都渋谷区初台1-1-1',
            'building' => '旧マンション101'
        ]);
        $item = Item::factory()->create();
        $this->actingAs($user);
        $newAddressData = [
            'postal_code' => '222-2222',
            'address' => '東京都新宿区西新宿2-2-2',
            'building' => '新マンション202',
        ];
        // 支払い方法の選択
        $this->post(route('address.update', ['item_id' => $item->id]), $newAddressData);
        $purchaseData = [
            'postal_code' => '222-2222',
            'address' => '東京都新宿区西新宿2-2-2',
            'building' => '新マンション202',
            'payment_method' => 'card',
            'price' => $item->price,
        ];
        // 購入処理
        $this->post(route('purchase.store', ['item_id' => $item->id]), $purchaseData)
            ->assertRedirect(route('index'));
        // 購入データの確認
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'card',
            'postal_code' => '222-2222',
            'address' => '東京都新宿区西新宿2-2-2',
            'building' => '新マンション202',
        ]);
    }
}
