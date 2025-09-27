<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\UserRegistrationRequest;
use App\Services\Auth\UserRegistrationService;
use Auth;

class RegisterEmailController extends BaseAuthController
{
    public function create()
    {
        return view(
            'pages.auth.registration-form');
    }

    public function store(UserRegistrationRequest $request)
    {
        $data = $request->validated();

        $userRegistrationService = new UserRegistrationService();
        $user = $userRegistrationService->register($data);

        Auth::login($user, true);
        $this->setActiveRole();

        return to_route('user.show', $user)
            ->with('warning', 'Вы успешно зарегистрировались! Пожалуйста, заполните, недостающую личную информацию.');
    }
}
