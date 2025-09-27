{{--Вкладка "изменить пароль"--}}
<div class="row">
    <div class="col-12">
        {{ Form::open(['url' => route('user.changePassword', $user), 'id' => 'pass-update-form']) }}
            @method('PUT')
            <input type="hidden" name="tabNumber" value="pass-tab">
            <div class="form-group row">
                <label for="inputPassword" class="col-md-5 col-form-label">Новый пароль</label>
                <div class="col-md-7">
                    <div class="password-block">
                        {{ Form::password('password', ['class' => "form-control",
                            'placeholder' => 'Новый пароль',
                            'id' => 'inputPassword',
                            'required' => true,
                            'autocomplete' => 'off']) }}
                        <a href="#" class="password-control fa fa-eye" onclick="return show_hide_password(this);"></a>
                    </div>
                </div>
            </div>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group row">
                <label for="inputPassword2" class="col-md-5 col-form-label">Новый пароль ещё раз</label>
                <div class="col-md-7">
                    {{ Form::password('password_confirmation', ['class' => "form-control",
                        'placeholder' => 'Новый пароль ещё раз',
                        'id' => 'inputPassword2',
                        'required' => true,
                        'autocomplete' => 'off']) }}
                </div>
            </div>
            @error('password_confirmation')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

        <div class="form-group row">
            <div class="col-md-3">
                <a href="{{ route('user.repeatSmsPassword', $user) }}"
                   type="submit" class="btn btn-warning float-md-left"
                   onclick="return confirm('Сгенерировать новый пароль автоматически и отправить его по СМС и почте?')">
                    <i class="fas fa-comments"></i>Сгенерировать новый пароль автоматически
                </a>
            </div>
            @can('delete', $user)
                <div class="col-md-3">
                    <a href="{{ route('user.loginAs', $user) }}"
                       type="submit" class="btn btn-info float-md-left">
                        <i class="fas fa-arrow-circle-right"></i>Войти от пользователя
                    </a>
                </div>
            @else
                <div class="col-md-3"></div>
            @endcan

            <div class="col-md-6">
                <button type="submit" class="btn btn-primary float-md-right">Изменить</button>
            </div>

        </div>

        {{ Form::close() }}
    </div>
</div>
