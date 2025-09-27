@extends('layouts.auth')

@section('content')
<img class="mb-3" src="{{ mix('/client/img/service-hero-image-2x-min.png') }}" alt="" width="72" height="72">
<h1 class="h3 mb-2">Ошибка 404</h1>
<p class="mb-2">Страница, которую вы запросили - <br><strong>не найдена</strong>.</p>
Вы можете <a href="/">перейти на главную</a>

@endsection
