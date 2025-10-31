<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 商品名で部分一致検索ができる
     */
    public function test_user_can_search_items_by_partial_match_name()
    {
        Item::factory()->create(['name' => 'ノートパソコン']);
        Item::factory()->create(['name' => 'パソコンバッグ']);
        Item::factory()->create(['name' => 'スマートフォン']);
        $response = $this->get('/?keyword=パソコン');
        $response->assertStatus(200);
        $response->assertSee('ノートパソコン');
        $response->assertSee('パソコンバッグ');
    }

    /**
     * 検索状態がマイリストでも保持されている
     */
    public function test_search_keyword_is_kept_on_mylist_page()
    {
        $user = User::factory()->create();
        $item1 = Item::factory()->create(['name' => 'ノートパソコン']);
        $item2 = Item::factory()->create(['name' => 'スマートフォン']);
        $user->likes()->attach($item1->id);
        $response = $this->actingAs($user)->get('/?keyword=ノート');
        $response->assertStatus(200);
        $response->assertSee('ノートパソコン');
        $response = $this->actingAs($user)->get('/?keyword=ノート&tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('ノートパソコン');
    }
}
