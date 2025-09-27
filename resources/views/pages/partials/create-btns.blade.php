<!-- создать новое обращение -->
<div class="card">
    <div class="btn-group w-100">
        <a href="{{ route('user.get_users', App\Models\Role::Client()) }}" class="btn btn-success col fileinput-button dz-clickable {{ HtmlHelper::activeLinkByUrlMask(route('user.get_users', App\Models\Role::Client())) }}">
            <i class="fas fa-plus"></i>
            <span>Создать новое обращение для зарегистрированного пользователя</span>
        </a>
        <a href="{{ route('user.create') }}" class="btn btn-primary col fileinput-button dz-clickable {{ HtmlHelper::activeLinkByUrlMask(route('user.create')) }}">
            <i class="fas fa-upload"></i>
            <span>Создать новое обращение для нового пользователя</span>
        </a>
    </div>
</div>
