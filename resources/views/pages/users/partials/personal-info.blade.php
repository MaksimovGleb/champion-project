{{ Form::open(['url' => route('user.update', $user), 'enctype' => "multipart/form-data", ]) }}
@csrf
@method('PUT')
<input type="hidden" name="tabNumber" value="personal-tab">
<input type="hidden" name="id" value="{{ $user->id }}">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="form-group row">
                <label for="inputName" class="col-md-3 col-form-label">Имя *</label>
                <div class="col-md-9">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName"  name="name"
                           placeholder="Имя" value="{{ old('name') ?? @$user->name}}" @cannot('update', $user) readonly @endcan>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="inputSurname" class="col-md-3 col-form-label">Фамилия *</label>
                <div class="col-md-9">
                    <input type="text" class="form-control @error('surname') is-invalid @enderror" id="inputSurname" name="surname"
                           placeholder="Фамилия" value="{{ old('surname') ?? @$user->surname}}"  @cannot('update', $user) readonly @endcan>
                    @error('surname')
                        <br>
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPatronymic" class="col-md-3 col-form-label">Отчество</label>
                <div class="col-md-9">
                    <input type="text" class="form-control @error('patronymic') is-invalid @enderror" id="inputPatronymic" name="patronymic"
                           placeholder="Отчество" value="{{ old('patronymic') ?? @$user->patronymic}}" @cannot('update', $user) readonly @endcan>
                    @error('patronymic')
                        <br>
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail" class="col-md-3 col-form-label">Email *</label>
                <div class="col-md-9">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" name="email"
                           placeholder="Email" value="{{ old('email') ?? @$user->email}}" @cannot('update', $user) readonly @endcan>
                    @error('email')
                        <br>
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPhone" class="col-md-3 col-form-label">Телефон *</label>
                <div class="col-md-9">
                    <input type="phone" class="form-control @error('phone') is-invalid @enderror" id="inputPhone" name="phone"
                           placeholder="" value="{{ old('phone') ?? @$user->phone}}" @cannot('update', $user) readonly @endcan>
                    @error('phone')
                        <br>
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @can('update', $user)
                <div class="form-group row">
                    <div class="offset-md-3 col-md-9">
                        <button type="submit" class="btn btn-primary float-md-right">Сохранить</button>
                    </div>
                </div>
            @endcan
        </div>
    </div>
{{ Form::close() }}
