{{ Form::open(['url' => route('judges.update', $judge->id)]) }}
@csrf
@method('PUT')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">{{$title}}</h3>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <div class="form-group row">
                                <label for="inputSurname" class="col-md-3 col-form-label">Фамилия *</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('surname') is-invalid @enderror" id="inputSurname" name="surname"
                                           placeholder="Фамилия" value="{{ old('surname') ?? $judge->surname }}">
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
                                           placeholder="Имя" value="{{ old('name') ?? $judge->name }}">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputPatronymic" class="col-md-3 col-form-label">Отчество</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('patronymic') is-invalid @enderror" id="inputPatronymic" name="patronymic"
                                           placeholder="Отчество" value="{{ old('patronymic') ?? $judge->patronymic }}">
                                    @error('patronymic')
                                    <br>
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Должность *</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('position') is-invalid @enderror" name="position"
                                           placeholder="Должность" value="{{ old('position') ?? $judge->position }}">
                                    @error('position')
                                    <br>
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Страна *</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('country') is-invalid @enderror" name="country"
                                           placeholder="Страна" value="{{ old('country') ?? $judge->country }}">
                                    @error('country')
                                    <br>
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Город *</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                                           placeholder="Город" value="{{ old('city') ?? $judge->city }}">
                                    @error('city')
                                    <br>
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Категория *</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control @error('category') is-invalid @enderror" name="category"
                                           placeholder="Категория" value="{{ old('category') ?? $judge->category }}">
                                    @error('category')
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
