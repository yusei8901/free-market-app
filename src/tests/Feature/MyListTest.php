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

    /** いいねした商品だけが表示される */
    public function test_liked_items_are_displayed_in_mylist()
    {
        $user = User::factory()->create();
        $likedItem = Item::factory()->create(['name' => 'LikedItem']);
        $anotherLikedItem = Item::factory()->create(['name' => 'AnotherLikedItem']);
        $user->likes()->attach([$likedItem->id, $anotherLikedItem->id]);
        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertViewIs('items.index');
        $response->assertSee('LikedItem');
        $response->assertSee('AnotherLikedItem');
    }

    /** 購入済み商品は「Sold」と表示される */
    public function test_sold_items_display_sold_label_in_mylist()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['sold' => true, 'name' => 'SoldItem']);
        $user->likes()->attach($item->id);
        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('Sold', false);
    }

    /** 未承認の場合は何も表示されない */
    public function test_unauthenticated_user_sees_login_prompt()
    {
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('お気に入りの商品を確認する場合はログインしてください', false);
        $response->assertSee('ログインはこちら', false);
    }
}
