<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function liked_items_are_displayed_in_mylist()
    {
        $user = User::factory()->create();
        $likedItem = Item::factory()->create(['name' => 'LikedItem']);
        $recommendItem = Item::factory()->create(['name' => 'RecommendItem']);
        $user->likes()->attach($likedItem->id);

        // マイページを取得
        $response = $this->actingAs($user)->get('/mypage?tab=mylist');
        $response->assertStatus(200);


        $html = $response->getContent();
        // マイリストセクションを確実に抜き出す（改良版）
        preg_match('/<div class="index__item" id="index__mylist">(.*?)<\/div>\s*<\/main>/s', $html, $matches);
        $mylistSection = $matches[1] ?? '';

        // デバッグ（必要なら出力確認）
        // file_put_contents('storage/logs/mylist_section.html', $mylistSection);

        // マイリスト内にLikedItemが含まれている
        $this->assertStringContainsString('LikedItem', $mylistSection);

        // マイリスト内にRecommendItemは含まれていない
        $this->assertStringNotContainsString('RecommendItem', $mylistSection);
    }

    /** @test */
    public function sold_items_display_sold_label_in_mylist()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['sold' => true, 'name' => 'SoldItem']);
        $user->likes()->attach($item->id);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('Sold', false);
    }

    /** @test */
    public function unauthenticated_user_sees_login_prompt()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('お気に入りの商品を確認する場合はログインしてください', false);
        $response->assertSee('ログインはこちら', false);
    }
}
