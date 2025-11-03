<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * メール認証を促すページ
     */
    public function notice()
    {
        return view('auth.verify-email');
    }

    /**
     * 確認メールを再送する処理
     */
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', '確認メールを再送しました。');
    }

    /**
     * メール認証をするページ
     */
    public function confirm()
    {
        $user = auth()->user();
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60), //有効期限（60分）
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        return view('auth.verify-user', [
            'verificationUrl' => $verificationUrl,
        ]);
    }

    /**
     * メール内のリンクをクリックしたときの処理
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill(); // 認証完了処理
        return redirect('/mypage/profile')
            ->with('success', 'メール認証が完了しました'); // 認証後の遷移先
    }
}
