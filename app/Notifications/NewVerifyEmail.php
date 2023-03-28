<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class NewVerifyEmail extends VerifyEmail
{
// 2023年3月8日追記：Laravel 日本語用ライブラリ（askdkc) を入れている場合は、オーバーライドができません。
// 下記追加
    public static $toMailCallback;
// 追加完
    
    protected function buildMailMessage($url)
    {
        // 元ファイルに対して、下記部分だけ書き換える
        return (new MailMessage)
            ->subject('メールアドレスの確認')
            ->line('ご登録ありがとうございます。')
            ->action('このボタンをクリック', $url)
            ->line('上記ボタンをクリックすると、ご登録が完了します！');
    }
}