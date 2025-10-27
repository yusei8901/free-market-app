<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * お名前が入力されていない場合、バリエーションメッセージが表示される
     */
    public function test_name_is_required()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $errors = session('errors')->getMessages();
        $this->assertEquals('お名前を入力してください', $errors['name'][0]);
    }

    /**
     * メールアドレスが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_email_is_required()
    {
        $response = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $errors = session('errors')->getMessages();
        $this->assertEquals('メールアドレスを入力してください', $errors['email'][0]);
    }

    /**
     * パスワードが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_password_is_required()
    {
        $response = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);
        $errors = session('errors')->getMessages();
        $this->assertEquals('パスワードを入力してください', $errors['password'][0]);
    }

    /**
     * パスワードが7文字以下の場合、バリデーションメッセージが表示される
     */
    public function test_password_must_be_at_least_8_characters()
    {
        $response = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'short7',
            'password_confirmation' => 'short7',
        ]);
        $errors = session('errors')->getMessages();
        $this->assertEquals('パスワードは8文字以上で入力してください', $errors['password'][0]);
    }

    /**
     * パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される
     */
    public function test_password_and_confirmation_must_match()
    {
        $response = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);
        $errors = session('errors')->getMessages();
        $this->assertEquals('パスワードと一致しません', $errors['password_confirmation'][0]);
    }

    /**
     * 全ての項目が入力されている場合、会員情報が登録され、プロフィール設定画面に遷移される
     * ※メール認証を追加した関係上、メール認証画面へ移動する
     */
    public function test_successful_registration_redirects_to_profile()
    {
        $response = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertRedirect('/email/verify');
    }
}
