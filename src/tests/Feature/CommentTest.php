<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログイン済みのユーザーはコメントを送信できる
     */
    public function test_authenticated_user_can_post_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('comments.store', $item->id), [
            'comment' => 'とても良い商品でした！',
        ]);
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'とても良い商品でした！',
        ]);
        $response = $this->get(route('items.item', $item->id));
        $response->assertStatus(200);
        $this->assertEquals(1, Comment::count());
    }

    /**
     * ログインしていないユーザーはコメントを送信できない
     */
    public function test_guest_cannot_post_comment()
    {
        $item = Item::factory()->create();
        $response = $this->post(route('comments.store', $item->id), [
            'comment' => 'ログインしていないユーザーのコメント',
        ]);
        $this->assertDatabaseMissing('comments', [
            'comment' => 'ログインしていないユーザーのコメント',
        ]);
        $response->assertRedirect(route('login'));
    }

    /**
     * コメント未入力の場合にバリデーションエラーメッセージが表示される
     */
    public function test_validation_error_when_comment_is_empty()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('comments.store', $item->id), [
            'comment' => '',
        ]);
        // バリデーションエラーを確認
        $response->assertSessionHasErrors(['comment']);
        $this->assertDatabaseCount('comments', 0);
    }

    /**
     * コメントが255文字を超える場合にバリデーションエラーが表示される
     */
    public function test_validation_error_when_comment_exceeds_255_characters()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $longComment = str_repeat('あ', 256); // 256文字
        $response = $this->actingAs($user)->post(route('comments.store', $item->id), [
            'comment' => $longComment,
        ]);
        // バリデーションエラーを確認
        $response->assertSessionHasErrors(['comment']);
        $this->assertDatabaseCount('comments', 0);
    }
}
