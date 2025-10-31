<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * メールアドレスが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_email_is_required()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);
        $errors = session('errors')->getMessages();
        $this->assertEquals('メールアドレスを入力してください', $errors['email'][0]);
    }

    /**
     * パスワードが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_password_is_required()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);
        $errors = session('errors')->getMessages();
        $this->assertEquals('パスワードを入力してください', $errors['password'][0]);
    }

    /**
     * 入力情報が間違っている場合、バリデーションメッセージが表示される
     */
    public function test_invalid_credentials_show_error_message()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);
        $errors = session('errors')->getMessages();
        $this->assertEquals('ログイン情報が登録されていません', $errors['email'][0]);
    }

    /**
     * 正しい情報が入力された場合、ログイン処理が実行される
     */
    public function test_valid_credentials_login_successfully()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);
        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/');
    }
}
