<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    /** 必要な情報が表示される（商品画像、商品名、ブランド名、価格、いいね数、コメント数、商品説明、商品情報（カテゴリ、商品の状態）、コメント数、コメントしたユーザー情報、コメント内容） */
    public function test_display_all_details_of_item()
    {
        // ▼ テスト用ユーザー作成
        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);

        // ▼ 商品作成
        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 9800,
            'description' => 'これはテスト用の商品説明です。',
            'condition' => '新品',
            'item_image' => 'products/test.jpg',
        ]);

        $category = Category::factory()->create(['name' => 'ファッション']);
        $item->categories()->attach($category->id);

        Like::factory()->count(1)->create(['user_id' => $user->id,'item_id' => $item->id]);

        Comment::factory()->count(1)->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'comment' => '素敵な商品ですね！',
        ]);

        $response = $this->get(route('items.item', $item->id));
        $response->assertStatus(200);

        $response->assertSee($item->name);
        $response->assertSee($item->brand);
        $response->assertSee(number_format($item->price));
        $response->assertSee($item->description);
        $response->assertSee($item->condition);
        $response->assertSee($category->name);
        $response->assertSee((string)Like::where('item_id', $item->id)->count());
        $response->assertSee((string)Comment::where('item_id', $item->id)->count());
        $response->assertSee('素敵な商品ですね！');
        $response->assertSee($user->name);
        $response->assertSee('storage/' . $item->item_image);
    }

    /** 複数選択されたカテゴリが表示されているか */
    public function test_display_some_categories_of_item()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 5000,
            'description' => 'これはテスト商品です。',
            'condition' => '新品',
            'item_image' => 'products/test.jpg',
        ]);
        $categories = Category::factory()->count(3)->create();
        $item->categories()->attach($categories->pluck('id'));

        // ▼ 商品詳細ページへアクセス
        $response = $this->get(route('items.item', $item->id));
        $response->assertStatus(200);
        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }
}
