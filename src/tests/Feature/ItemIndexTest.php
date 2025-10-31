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
    /** 全商品を取得できる */
    public function test_all_items_are_displayed()
    {
        Item::factory()->count(3)->create();
        $response = $this->get('/');
        $response->assertStatus(200);
        foreach (Item::all() as $item) {
            $response->assertSee($item->name);
        }
    }

    /** 購入済みの商品は「Sold」と表示される */
    public function test_sold_items_display_sold_label()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $this->post('/purchase/{item_id}');
        $response = $this->get('/');
        $response->assertSee('Sold');
    }

    /** 自分が出品した商品は表示されない */
    public function test_user_own_items_are_not_displayed_in_list()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $myItem = Item::factory()->create(['user_id' => $user->id]);
        $otherItem = Item::factory()->create(['user_id' => $otherUser->id]);
        $response = $this->actingAs($user)->get('/');
        $response->assertDontSee($myItem->name);
        $response->assertSee($otherItem->name);
    }
}
