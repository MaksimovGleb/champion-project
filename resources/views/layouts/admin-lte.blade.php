<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
{{--
<meta name="referrer" content="origin">
Ломает редирект в FormRequest при нарушении валидации
--}}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Личный кабинет</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ mix('/client/css/app.css') }}" rel="stylesheet">
		@stack('styles')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
        <div class="wrapper" id="app">
            @include('pages.partials.nav-bar')

            @yield('sidebar')
            <div class="content-wrapper">
                @yield('menu')
                <div class="content">
                    <div class="container-fluid pb-1">
                        @yield('content')
                    </div>
                </div>
            </div>
            @yield('footer')
        </div>

        <!-- REQUIRED SCRIPTS -->
        <script src="{{ mix('/client/js/app.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.11.5/sorting/datetime-moment.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        @stack('custom-scripts')

        {{--тост с алертами--}}
        @include('pages.partials.alerts-script')
    </body>
</html>
