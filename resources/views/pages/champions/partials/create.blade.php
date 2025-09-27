{{ Form::open(['url' => route('champions.store'), 'enctype' => "multipart/form-data", ]) }}
@csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Зарегистрировать участника</h3>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <div class="form-group row">
                                <label for="inputSurname" class="col-md-3 col-form-label">Фамилия *</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('surname') is-invalid @enderror" id="inputSurname" name="surname"
                                           placeholder="Фамилия" value="{{ old('surname') }}">
                                    @error('surname')
                                    <br>
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputName" class="col-md-3 col-form-label">Имя *</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName"  name="name"
                                           placeholder="Имя" value="{{ old('name') }}">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputPatronymic" class="col-md-3 col-form-label">Отчество</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('patronymic') is-invalid @enderror" id="inputPatronymic" name="patronymic"
                                           placeholder="Отчество" value="{{ old('patronymic') }}">
                                    @error('patronymic')
                                    <br>
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Тренер *</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('coach') is-invalid @enderror" name="coach"
                                           placeholder="Тренер" value="{{ old('coach') }}">
                                    @error('coach')
                                    <br>
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Разряд *</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('category') is-invalid @enderror" name="category"
                                           placeholder="Разряд" value="{{ old('category') }}">
                                    @error('category')
                                    <br>
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Вес *</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('weight') is-invalid @enderror" name="weight"
                                           placeholder="Вес" value="{{ old('weight') }}">
                                    @error('weight')
                                    <br>
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Дата рождения *</label>
                                <div class="col-md-9">
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date"
                                           placeholder="Дата рождения" value="{{ old('birth_date') }}">
                                    @error('birth_date')
                                    <br>
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="offset-md-3 col-md-9">
                                    <button type="submit" class="btn btn-primary float-md-right">Сохранить</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}
