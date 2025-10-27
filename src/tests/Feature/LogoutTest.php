<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_logout_successfully()
    {
        $user = User::factory()->create();
        // ユーザーとしてログイン
        $this->actingAs($user);
        // ログアウト処理を実行
        $response = $this->post('/logout');
        // ログアウト後の挙動を確認
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
