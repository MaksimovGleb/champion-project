@extends('layouts.auth')
@section('content')

<div class="form-signin">
    <h1 class="h3 mb-3 font-weight-normal">Регистрация По e-mail</h1>

    <div class="tab-pane" id="email" role="tabpanel" aria-labelledby="email-tab">
        {{ Form::open(['url' => route('user.register.store')]) }}
        @method('POST')
            <label for="inputEmail" class="sr-only">Email адрес</label>
            <input type="email" value="{{ old('email') }}" id="inputEmail" class="form-control"
                   placeholder="Email адрес" name="email" required autofocus>

            <label for="inputName" class="sr-only">Имя</label>
            <input type="text" value="{{ old('name') }}" id="inputName" class="form-control"
                   placeholder="Имя" name="name" required>

            <button class="btn btn-lg btn-primary btn-block mb-2" type="submit">Регистрация</button>
        {{ Form::close() }}
    </div>

	<div class="row">
		<div class="checkbox col-12 mb-2">
			<a href="{{ route('user.login') }}">вернуться к авторизации</a>
		</div>

		<div class="checkbox col-12 mb-2">
            <a href="{{ route('user.password.create') }}">Забыли пароль</a>
		</div>
	</div>

</div>
@endsection
