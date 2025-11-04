<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test
     * 会員登録後、認証メールが送信される
     */
    public function test_registration_sends_verification_email()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'TestUser',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(); // 登録後のリダイレクト確認
        $user = User::first();
        Notification::assertSentTo($user, VerifyEmail::class); // 認証メールが送信されたか確認
    }

    /** @test
     * メール認証誘導画面で「認証はこちらから」ボタンを押下するとメール認証サイトに遷移する
     */
    public function test_verify_email_button_redirects_to_verification_site()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user);

        // メール認証導線画面を表示
        $response = $this->get('/email/verify/user');
        $response->assertStatus(200);
        $response->assertViewIs('auth.verify-user');
        $response->assertViewHas('verificationUrl'); // Blade に渡っているか確認
        $response->assertSee('/email/verify/'); // 実際のURL表示確認
        $response->assertSee('認証を完了する'); // ボタンテキスト確認

        // コントローラーが生成する署名付きURLを再現
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        // 「認証を完了する」ボタンのリンク先へアクセス（メールクリック相当）
        $followResponse = $this->get($verificationUrl);
        $followResponse->assertRedirect('/mypage/profile');
    }

    /** @test */
    public function test_user_can_verify_email_and_redirect_to_profile()
    {
        $user = User::factory()->unverified()->create(); // email_verified_at = null

        $this->actingAs($user);

        // 認証リンクを生成
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        // メール認証完了処理を実行
        $response = $this->get($verificationUrl);

        $response->assertRedirect('/mypage/profile');
        $response->assertSessionHas('success', 'メール認証が完了しました');

        // ユーザーが verified 状態になっているか確認
        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
