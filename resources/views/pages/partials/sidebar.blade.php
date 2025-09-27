<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="{{ route('user.show',  Auth::user()->id) }}" class="d-block">{{ Auth::check() ? Auth::user()->FullName  : ''}}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{--Участники соревнований--}}
                <li class="nav-item">
                    <a href="{{ route('champions.index') }}" class="nav-link {{ HtmlHelper::activeLink('champions.*') }}">
                        <i class="nav-icon far fa-circle text-danger"></i>
                        <p>Участники соревнований</p>
                    </a>
                </li>

                {{--Судьи соревнований--}}
                <li class="nav-item">
                    <a href="{{ route('judges.index') }}" class="nav-link {{ HtmlHelper::activeLink('judges.*') }}">
                        <i class="nav-icon far fa-circle text-warning"></i>
                        <p>Судьи соревнований</p>
                    </a>
                </li>

                {{--Отсортированные таблицы соревнований--}}
                <li class="nav-item">
                    <a href="{{ route('tournaments.index') }}" class="nav-link {{ HtmlHelper::activeLink('tournaments.*') }}">
                        <i class="nav-icon far fa-circle text-success"></i>
                        <p>Отсортированные таблицы соревнований</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.logout') }}" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <p> Выход</p>
                    </a>
                </li>
                <p></p>
                {{--для мобильной верски что бы выход было видно--}}
                <p></p>
            </ul>
        </nav>
    </div>
</aside>
