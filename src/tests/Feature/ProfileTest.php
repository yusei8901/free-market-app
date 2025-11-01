<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test
     * 変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）
     */
    public function test_profile_edit_page_displays_user_initial_values_correctly()
    {
        // 画像を想定してstorageをfake化
        Storage::fake('public');
        // テストユーザーを作成
        $user = User::factory()->create([
            'name' => 'テスト太郎',
            'profile_image' => 'profile/test_image.jpg',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区道玄坂1-2-3',
            'building' => '渋谷ビル301'
        ]);
        // ログイン状態を作成
        $response = $this->actingAs($user)->get('/mypage/profile');
        // ステータスコード確認
        $response->assertStatus(200);
        // 各項目の初期値が正しく表示されているか確認
        $response->assertSee('テスト太郎', false); // name
        $response->assertSee('123-4567', false); // postal_code
        $response->assertSee('東京都渋谷区道玄坂1-2-3', false); // address
        $response->assertSee('渋谷ビル301', false); // building
        $response->assertSee(asset('storage/' . $user->profile_image), false);
    }
}
