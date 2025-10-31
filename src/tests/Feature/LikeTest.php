<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /** いいねアイコンを押下することによって、いいねした商品として登録することができる */
    public function user_can_like_an_item_and_like_count_increases()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $response = $this->actingAs($user)->post(route('items.like', $item->id));
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $response = $this->get(route('items.show', $item->id));
        $response->assertSee('1');
    }

    /** 追加済みのアイコンは色が変化する */
    public function liked_icon_changes_color_when_liked()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $user->likes()->attach($item->id);
        $response = $this->actingAs($user)->get(route('items.item', $item->id));
        $response->assertSee('gold', false);
    }

    /** 再度いいねアイコンを押下することによって、いいねを解除することができる */
    public function user_can_unlike_an_item_and_like_count_decreases()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $user->likes()->attach($item->id);
        $response = $this->actingAs($user)->post(route('items.like', $item->id));

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $response = $this->get(route('items.item', $item->id));
        $response->assertSee('0');
    }
}
