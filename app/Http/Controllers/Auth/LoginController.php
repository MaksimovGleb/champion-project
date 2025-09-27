<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;

use Auth;

/**
 * @todo Проверить, как работает запоминание без: Auth::viaRemember()
 * Class LoginEmailController
 */
class LoginController extends BaseAuthController
{
    public function create()
    {
        return view('pages.auth.login-email-form');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $this->setActiveRole();

        if ( Auth::user()->getActiveRole()) {
            if (Auth::user()->isProfileEmpty()) {
                return to_route('user.show', Auth::user()->id)
                    ->with('warning', 'Пожалуйста, заполните, недостающую личную информацию.');
            }

            return redirect()->intended('/');
        }
        return to_route('user.logout')->with('error', 'У вас нет ни одной роли.');
    }
}
