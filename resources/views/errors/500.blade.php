@extends('layouts.auth')

@section('content')
<img class="mb-3" src="{{ mix('/client/img/service-hero-image-2x-min.png') }}" alt="" width="72" height="72">
<h1 class="h3 mb-2">Ошибка 500</h1>
<p class="mb-2">На сервере произошла <br>непредвиденная ошибка. <br>Мы уже занимаемся её устранением.</p>
Вы можете <a href="/">перейти на главную</a>

@endsection
