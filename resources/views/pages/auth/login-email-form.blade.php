@extends('layouts.auth')

@section('content')
    {{ Form::open(['url' => route('user.login.store'), 'class' => 'form-signin']) }}
    @method('POST')
        <h1 class="h3 mb-3 font-weight-normal">Личный кабинет </h1>
        <label for="inputEmail" class="sr-only">Имя пользователя </label>
        <input type="email|phone"
               value="{{ ($email = Session::get('username')) ? $email : '' }}"
               id="inputEmail"
               class="form-control"
               placeholder="Email адрес"
               name="username" required autofocus>
        <br>

        <div class="password-block">
            <label for="inputPassword" class="sr-only">Пароль</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Пароль" name="password" required>
            <a href="#" class="password-control fa fa-eye" onclick="return show_hide_password(this);"></a>
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="remember"> Запомнить меня
            </label>
        </div>

{{--        <div class="row">--}}
{{--            <div class="checkbox col-12 mb-2">--}}
{{--                <a href="{{ route('user.register') }}">Зарегистрироваться</a>--}}
{{--            </div>--}}
{{--            <div class="checkbox col-12 mb-2">--}}
{{--                <a href="{{ route('user.password.create') }}">Забыли пароль</a>--}}
{{--            </div>--}}
{{--        </div>--}}

        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    {{ Form::close() }}
@endsection
