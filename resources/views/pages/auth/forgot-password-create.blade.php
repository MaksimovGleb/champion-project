@extends('layouts.auth')

@section('content')

    {{ Form::open(['url' => route('user.password.store'), 'class' => 'form-signin']) }}
    @method('POST')
        <h1 class="h3 mb-3 font-weight-normal">{{ $title }}</h1>

        <label for="username" class="sr-only">Email адрес</label>

        <input type="text" value=""
               id="username" class="form-control"
               placeholder="Email адрес"
               name="username" required autofocus autocomplete="off">
        <br>
        <button class="btn btn-lg btn-primary btn-block mb-2" type="submit">Сбросить пароль</button>

        <div class="row">
            <div class="checkbox col-12 mb-2">
                <a href="{{ route('user.login') }}">Вернуться к авторизации</a>
            </div>

            <div class="checkbox col-12 mb-2">
                <a href="{{ route('user.register') }}">Зарегистрироваться</a>
            </div>
        </div>
    {{ Form::close() }}
@endsection
