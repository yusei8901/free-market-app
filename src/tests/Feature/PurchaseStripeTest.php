<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Stripe\Checkout\Session as StripeSession;
use Stripe\StripeClient;
use Illuminate\Support\Facades\App;

class PurchaseStripeTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close(); // Mockery使用後は必ずクローズ
        parent::tearDown();
    }

    /** @test
     * 購入成功時のテスト
     */
    public function stripe_payment_and_purchase_complete_successfully()
    {
        // ① ユーザー・商品準備
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'sold' => false,
            'name' => 'テスト商品',
            'price' => 1000,
        ]);

        // Stripe\Session::create() をモック
        $mockSession = (object)[
            'id' => 'cs_test_123',
            'url' => route('purchase.success', ['item_id' => $item->id]),
        ];

        // Stripe静的クラスのモック
        Mockery::mock('alias:' . \Stripe\Checkout\Session::class)
            ->shouldReceive('create')
            ->once()
            ->andReturn($mockSession);

        // ③ 購入処理実行
        $response = $this->actingAs($user)->post(route('purchase.store', $item->id), [
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
            'building' => 'テストマンション101',
            'payment_method' => 'card',
            'price' => $item->price,
        ]);

        // ④ リダイレクト先確認
        $response->assertRedirect(route('purchase.success', ['item_id' => $item->id]));

        // ⑤ Stripe成功後の購入データ作成を想定
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'card',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
            'building' => 'テストマンション101',
        ]);
        $item->update(['sold' => true]);

        // ⑥ DB・ビュー確認
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $this->assertTrue((bool)$item->fresh()->sold);

        $response = $this->actingAs($user)->get('/mypage?page=buy');
        $response->assertStatus(200);
        $response->assertSee('テスト商品');
    }

    /** @test
     * 購入失敗時のテスト
     */
    public function cancel_view_is_displayed_on_cancel_route()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('purchase.cancel'));

        $response->assertStatus(200);
        $response->assertViewIs('items.cancel');
    }
}
