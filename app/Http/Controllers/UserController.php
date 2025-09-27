<?php

namespace App\Http\Controllers;

use App\Events\User\EventPasswordChanged;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\UserRequest;
use App\Models\Role;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /** show(по сути это show и edit всего пользователя) */
    public function edit(User $user)
    {
        return to_route('user.show', $user);
    }

    public function show(User $user)
    {
        if (Auth::user()->can('view', $user)) {
            $user = User::with([ ])->find($user->id);

            return view('pages.users.show-edit', [
                'user' => $user,
                'title' => 'Профиль',
                'checked' => true,
            ]);

        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    /** Изменение пароля */
    public function changePassword(ChangePasswordRequest $request, User $user)
    {
        if (Auth::user()->can('changePassword', $user)) {
            $data = $request->validated();
            $user->updatePassword($data['password']);
            EventPasswordChanged::dispatch($user, $data['password']);
            return to_route('user.show', $user)
                ->with('success', 'Пароль изменен!')->with('tabNumber', 'pass-tab');
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    /**  Отправить пароль повторно */
    public function repeatSmsPassword(User $user)
    {
        if (Auth::user()->can('changePassword', $user)) {
            $password = User::generatePassword();
            $user->updatePassword($password);
            EventPasswordChanged::dispatch($user, $password);
            return to_route('user.show', $user)
                ->with('success', 'Пароль изменен!')->with('tabNumber', 'pass-tab');
        }
        return redirect()->back()->with('error', 'нет права!');
    }

    /** Перезайти от другого пользователя */
    public function loginAs(Request $request, User $user)
    {
        if (Auth::user()->can('delete', $user)) {
            $request->session()->forget('activeRoleId');
            Auth::login($user);
            //$href = HtmlHelper::getUrl() . 'lc/tasks/' . $task->id;
            return back()
                ->with('success', "Вы успешно залогинились как {$user->name}")->with('tabNumber', 'pass-tab');
        }
        return redirect()->back()->with('error', 'нет права!');
    }

    /**  Изменение полей пользователя */
    public function update(UserRequest $request, User $user)
    {
        if (Auth::user()->can('update', $user)) {
            $user = User::Edit($request->validated(), $user->id);

            return to_route('user.show', $user->id)
                ->with('success', 'Профиль изменен!');
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    /**  Переключение активной роли */
    public function switchRole(Role $role)
    {
        $user = Auth::user();
        if ($user->roles->contains($role)) {
            $user->setActiveRole($role);
        }

        return redirect()->back();
    }
}
