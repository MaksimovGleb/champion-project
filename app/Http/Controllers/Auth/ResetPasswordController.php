<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Notifications\User\NotificationPasswordChanged;
use App\Notifications\User\NotificationRecoveryPass;
use App\Services\Sms\SmsVerification;
use HtmlHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;

class ResetPasswordController extends BaseAuthController
{
    public function create()
    {
        return view('pages.auth.forgot-password-create', [
            'title' => 'Личный кабинет',
        ]);
    }

    public function store(Request $request)
    {
        $username = $request->get('username');
        $fromEmail = str_contains($username, '@');

        if ($fromEmail) {
            $user = User::where('email', $username)->first();

            if (!$user) {
                return to_route('user.password.create')
                    ->with('error', 'Пользователь с таким email не найден');
            }

            $href = route('user.password.reset', [
                'email' => $user->email,
                'code' => (new SmsVerification)->generateOneTimePassword($user)
            ]);
            Notification::send($user,
                new NotificationRecoveryPass($user, $href));

            return to_route('user.login')
                ->with('success', 'Ссылка на сброс пароля отправлена вам на почту: '.$user->email);
        }

        return to_route('user.password.create')
            ->with('error', 'Неверно введён email');
    }

    public function reset(string $email, string $code, bool $new = false)
    {
        $user = User::Where('email', $email)->firstOrFail();
        $realCode = $user->oneTimePassword->password;

        if ($code === $realCode) {
            $user->updatePassword($user->oneTimePassword->password, true);
            if ($new) {
                $href = HtmlHelper::getUrl() . 'auth';
                Notification::send($user,
                    new NotificationPasswordChanged($user, $user->oneTimePassword->password, $href));

                return Redirect::to(HtmlHelper::getUrl() . 'auth?message=Пароль успешно изменён и отправлен вам на ' . $user->email. '&title=Успешно');
            }else{
                $href = route('user.login');
                Notification::send($user,
                    new NotificationPasswordChanged($user, $user->oneTimePassword->password, $href));

                return to_route('user.login')
                    ->with('success', "Пароль успешно изменён и отправлен вам на {$user->email}");
            }
        }

        return to_route('user.login')
            ->with('error', 'Не правильная ссылка сброса пароля!');
    }

    public function edit(string $phone)
    {
        return view('pages.auth.forgot-password-edit', [
            'title' => 'Личный кабинет',
            'phone' => $phone,
        ]);
    }
}
