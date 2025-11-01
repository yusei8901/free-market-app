<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ItemStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 商品出品画面にて必要な情報が保存できること（カテゴリ、商品の状態、商品名、ブランド名、商品の説明、販売価格）
     *
     * @test
     */
    public function test_registered_item_information_is_saved_correctly()
    {
        // === 準備 ===
        Storage::fake('public');
        $user = User::factory()->create(); // ログインユーザー
        $categories = Category::factory()->count(3)->create(); // カテゴリ
        // === テストデータ ===
        $data = [
            'item_image' => UploadedFile::fake()->image('item.jpg'),
            'categories' => $categories->pluck('id')->toArray(),
            'condition' => '良好',
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'これはテスト商品の説明です。',
            'price' => 1200,
        ];
        // === 実行 ===
        $response = $this->actingAs($user)
            ->post(route('items.store'), $data);
        // === 検証 ===
        // リダイレクトされること（出品完了後のページに）
        $response->assertRedirect('mypage');

        // 画像が保存されていること
        $item = Item::first();
        Storage::disk('public')->assertExists($item->item_image);

        // itemsテーブルにデータが保存されていること
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'これはテスト商品の説明です。',
            'price' => 1200,
            'condition' => '良好',
        ]);

        // 中間テーブル（category_itemなど）に関連付けが保存されていること
        foreach ($categories as $category) {
            $this->assertDatabaseHas('category_item', [
                'item_id' => $item->id,
                'category_id' => $category->id,
            ]);
        }
    }
}
